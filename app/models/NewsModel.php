<?php

namespace App\Models;

use PDO;

class NewsModel extends BaseModel
{
    protected $table = 'news';

    public function __construct()
    {
        parent::__construct();
    }

    public function findBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addNewsCategory($newsId, $categoryId)
    {
        try {
            $sql = "INSERT INTO news_category_relations (news_id, category_id, created_at) 
                VALUES (:news_id, :category_id, NOW())";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':news_id', $newsId, \PDO::PARAM_INT);
            $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log('Error adding news category: ' . $e->getMessage());
            return false;
        }
    }

    public function createWithCategories($data, $categoryIds = [])
    {
        try {
            // Begin transaction
            $this->db->beginTransaction();

            // Insert the news article
            $sql = "INSERT INTO {$this->table} (
                title, slug, summary, content, featured_image,
                meta_title, meta_description, status, featured, views,
                created_by, published_at, created_at, updated_at
            ) VALUES (
                :title, :slug, :summary, :content, :featured_image, 
                :meta_title, :meta_description, :status, :featured, :views,
                :created_by, :published_at, :created_at, :updated_at
            )";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(':title', $data['title']);
            $stmt->bindValue(':slug', $data['slug']);
            $stmt->bindValue(':summary', $data['summary'] ?? null);
            $stmt->bindValue(':content', $data['content']);
            $stmt->bindValue(':featured_image', $data['featured_image'] ?? null);
            $stmt->bindValue(':meta_title', $data['meta_title'] ?? null);
            $stmt->bindValue(':meta_description', $data['meta_description'] ?? null);
            $stmt->bindValue(':status', $data['status']);
            $stmt->bindValue(':featured', $data['featured'] ?? 0, PDO::PARAM_INT);
            $stmt->bindValue(':views', $data['views'] ?? 0, PDO::PARAM_INT);
            $stmt->bindValue(':created_by', $data['created_by']);
            $stmt->bindValue(':published_at', $data['published_at'] ?? null);
            $stmt->bindValue(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'));
            $stmt->bindValue(':updated_at', $data['updated_at'] ?? date('Y-m-d H:i:s'));

            $stmt->execute();
            $newsId = $this->db->lastInsertId();

            if (!$newsId) {
                throw new \Exception("Failed to get last insert ID for news article");
            }

            // Add categories if provided
            if (!empty($categoryIds)) {
                $categoryStmt = $this->db->prepare(
                    "INSERT INTO news_category_relations (news_id, category_id, created_at) 
                    VALUES (:news_id, :category_id, NOW())"
                );

                foreach ($categoryIds as $categoryId) {
                    $categoryStmt->bindValue(':news_id', $newsId, PDO::PARAM_INT);
                    $categoryStmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
                    $categoryStmt->execute();
                }
            }

            // Commit the transaction
            $this->db->commit();

            return $newsId;
        } catch (\Exception $e) {
            // Rollback on error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            var_dump($e->getMessage());
            die();
            return false;
        }
    }

    public function getNewsCategories($newsId)
    {
        try {
            $sql = "SELECT nc.id, nc.name, nc.slug, nc.description, nc.image, nc.status
                FROM news_categories nc 
                JOIN news_category_relations ncr ON nc.id = ncr.category_id 
                WHERE ncr.news_id = :news_id
                ORDER BY nc.name ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':news_id', $newsId, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error getting news categories: " . $e->getMessage());
            return [];
        }
    }

    public function updateWithCategories($id, array $newsData, array $categories = [])
    {
        try {
            $this->db->beginTransaction();

            // 1. Update the main news record
            $this->update($id, $newsData);

            // 2. Delete existing category associations using prepared statement
            $deleteSQL = "DELETE FROM news_category_relations WHERE news_id = :news_id";
            $deleteStmt = $this->db->prepare($deleteSQL);
            $deleteStmt->bindValue(':news_id', $id, \PDO::PARAM_INT);
            $deleteStmt->execute();

            // 3. Insert new category associations using prepared statement
            if (!empty($categories)) {
                $insertSQL = "INSERT INTO news_category_relations (news_id, category_id, created_at) 
                          VALUES (:news_id, :category_id, NOW())";
                $insertStmt = $this->db->prepare($insertSQL);

                foreach ($categories as $categoryId) {
                    $insertStmt->bindValue(':news_id', $id, \PDO::PARAM_INT);
                    $insertStmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
                    $insertStmt->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            var_dump($e->getMessage());
            die();
            return false;
        }
    }

    /**
     * Get paginated news list with filters, search and sorting
     * 
     * @param array $options Array of options including:
     *      - status: string|array Filter by status (published, draft, archived)
     *      - category_id: int Filter by category ID
     *      - author_id: int Filter by author ID
     *      - featured: bool Filter by featured status
     *      - search: string Search term for title, slug, summary
     *      - sort: string Field to sort by (default: "created_at")
     *      - direction: string Sort direction (default: "desc")
     *      - page: int Page number (default: 1)
     *      - per_page: int Records per page (default: 10)
     *      - include_categories: bool Whether to include category data (default: false)
     * @return array Paginated news with pagination metadata
     */
    public function getNewsList($options = [])
    {
        // Extract options with defaults
        $page = max(1, $options['page'] ?? 1);
        $perPage = max(1, $options['per_page'] ?? 10);
        $sort = $options['sort'] ?? 'created_at';
        $direction = $options['direction'] ?? 'desc';
        $search = $options['search'] ?? '';
        $status = $options['status'] ?? null;
        $categoryId = $options['category_id'] ?? null;
        $authorId = $options['author_id'] ?? null;
        $featured = isset($options['featured']) ? (bool)$options['featured'] : null;
        $includeCategories = $options['include_categories'] ?? false;

        // Prepare columns to select
        $columns = [
            'n.id',
            'n.title',
            'n.slug',
            'n.summary',
            'n.featured_image',
            'n.status',
            'n.featured',
            'n.views',
            'n.created_by',
            'n.published_at',
            'n.created_at',
            'n.updated_at',
            'u.username AS author_name'
        ];

        // Prepare joins
        $joins = [
            'LEFT JOIN users u ON n.created_by = u.id'
        ];

        // Prepare filters
        $filters = [];

        if ($status !== null) {
            if (is_array($status)) {
                // If status is an array, create an IN condition in additional_where
                $statusPlaceholders = [];
                $additionalWhere = " AND n.status IN (";
                foreach ($status as $key => $statusValue) {
                    $placeholder = ":status{$key}";
                    $statusPlaceholders[$placeholder] = $statusValue;
                    $additionalWhere .= $placeholder . ", ";
                }
                $additionalWhere = rtrim($additionalWhere, ", ") . ")";
            } else {
                $filters['n.status'] = $status;
                $additionalWhere = "";
            }
        } else {
            $additionalWhere = "";
        }

        if ($authorId !== null) {
            $filters['n.created_by'] = $authorId;
        }

        if ($featured !== null) {
            $filters['n.featured'] = $featured ? 1 : 0;
        }

        // Handle category filtering with a join if needed
        if ($categoryId !== null) {
            $joins[] = 'INNER JOIN news_category_relations ncr ON n.id = ncr.news_id';
            $filters['ncr.category_id'] = $categoryId;
        }

        // Prepare search fields
        $searchFields = ['n.title', 'n.slug', 'n.summary', 'n.content'];

        // Set up options for the paginated query
        $queryOptions = [
            'columns' => $columns,
            'joins' => $joins,
            'filters' => $filters,
            'sort' => $sort,
            'direction' => $direction,
            'page' => $page,
            'limit' => $perPage,
            'table_alias' => 'n',
            'search_term' => !empty($search) ? "%{$search}%" : null,
            'search_fields' => $searchFields,
            'additional_where' => $additionalWhere ?? ""
        ];

        // Get paginated results
        $result = $this->getPaginatedCustom($queryOptions);

        // Include categories if requested
        if ($includeCategories && !empty($result['items'])) {
            $newsIds = array_column($result['items'], 'id');

            // Get categories for all news items in one query
            $categoriesQuery = "
            SELECT ncr.news_id, nc.*
            FROM news_category_relations ncr
            JOIN news_categories nc ON ncr.category_id = nc.id
            WHERE ncr.news_id IN (" . implode(',', array_fill(0, count($newsIds), '?')) . ")
            ORDER BY nc.name ASC
        ";

            $stmt = $this->db->prepare($categoriesQuery);
            foreach ($newsIds as $index => $id) {
                $stmt->bindValue($index + 1, $id, \PDO::PARAM_INT);
            }
            $stmt->execute();
            $allCategories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Group categories by news_id
            $categoriesByNewsId = [];
            foreach ($allCategories as $category) {
                $newsId = $category['news_id'];
                unset($category['news_id']); // Remove the news_id from the category data
                $categoriesByNewsId[$newsId][] = $category;
            }

            // Add categories to each news item
            foreach ($result['items'] as &$newsItem) {
                $newsItem['categories'] = $categoriesByNewsId[$newsItem['id']] ?? [];
            }
        }

        return $result;
    }
    public function getAllNews($limit = null, $offset = 0, $status = 'published', $categoryId = null, $featured = null)
    {
        try {
            // Truy vấn chính để lấy thông tin tin tức
            $sql = "SELECT n.*, 
                  c.name AS primary_category_name, 
                  u.username AS author_name
           FROM news n
           LEFT JOIN news_categories c ON n.category_id = c.id
           LEFT JOIN users u ON n.created_by = u.id
           WHERE 1=1";
            $params = [];

            // Thêm điều kiện lọc theo trạng thái
            if ($status !== null) {
                $sql .= " AND n.status = :status";
                $params[':status'] = $status;
            }

            // Thêm điều kiện lọc theo danh mục chính
            if ($categoryId !== null) {
                $sql .= " AND (n.category_id = :category_id OR EXISTS (
                SELECT 1 FROM news_category_relations ncr 
                WHERE ncr.news_id = n.id AND ncr.category_id = :category_id
            ))";
                $params[':category_id'] = $categoryId;
            }

            // Thêm điều kiện lọc theo tin nổi bật
            if ($featured !== null) {
                $sql .= " AND n.featured = :featured";
                $params[':featured'] = $featured ? 1 : 0;
            }

            // Sắp xếp theo thời gian xuất bản mới nhất
            $sql .= " ORDER BY n.published_at DESC, n.created_at DESC";

            // Thêm giới hạn số lượng bản ghi
            if ($limit !== null) {
                $sql .= " LIMIT :offset, :limit";
                $params[':offset'] = (int)$offset;
                $params[':limit'] = (int)$limit;
            }

            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho các tham số
            foreach ($params as $key => $value) {
                if (strpos($key, 'limit') !== false || strpos($key, 'offset') !== false) {
                    $stmt->bindValue($key, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($key, $value);
                }
            }

            $stmt->execute();
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Lấy tất cả các danh mục cho mỗi bài viết
            if (!empty($news)) {
                $newsIds = array_column($news, 'id');
                $placeholders = implode(',', array_fill(0, count($newsIds), '?'));

                $categorySql = "SELECT ncr.news_id, nc.id AS category_id, nc.name AS category_name
                           FROM news_category_relations ncr
                           JOIN news_categories nc ON ncr.category_id = nc.id
                           WHERE ncr.news_id IN ({$placeholders})";

                $categoryStmt = $this->db->prepare($categorySql);

                // Gán các tham số bài viết vào truy vấn
                foreach ($newsIds as $index => $newsId) {
                    $categoryStmt->bindValue($index + 1, $newsId, PDO::PARAM_INT);
                }

                $categoryStmt->execute();
                $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

                // Nhóm các danh mục theo news_id
                $newsCategories = [];
                foreach ($categories as $category) {
                    $newsId = $category['news_id'];
                    if (!isset($newsCategories[$newsId])) {
                        $newsCategories[$newsId] = [];
                    }
                    $newsCategories[$newsId][] = $category;
                }

                // Thêm danh sách danh mục vào mỗi bài viết
                foreach ($news as &$item) {
                    $item['categories'] = isset($newsCategories[$item['id']]) ? $newsCategories[$item['id']] : [];
                    $item['category_names'] = [];

                    if (!empty($item['categories'])) {
                        foreach ($item['categories'] as $cat) {
                            $item['category_names'][] = $cat['category_name'];
                        }
                    }

                    // Nếu không có danh mục phụ nhưng có danh mục chính, thêm vào danh sách
                    if (empty($item['category_names']) && !empty($item['primary_category_name'])) {
                        $item['category_names'][] = $item['primary_category_name'];
                    }

                    // Chuyển mảng tên danh mục thành chuỗi (tùy theo nhu cầu sử dụng)
                    $item['categories_string'] = implode(', ', $item['category_names']);
                }
            }

            return $news;
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy dữ liệu tin tức: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Lấy danh sách danh mục kèm theo số lượng bài viết
     */
    public function getActiveCategories()
    {
        try {
            // Đếm số lượng bài viết cho mỗi danh mục một cách độc lập
            // không phụ thuộc vào filter hiện tại
            $sql = "SELECT c.id, c.name, COUNT(n.id) as post_count
                FROM news_categories c
                LEFT JOIN news n ON n.category_id = c.id AND n.status = 'published'
                WHERE c.status = 'active'
                GROUP BY c.id, c.name
                ORDER BY c.name ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy danh mục tin tức: " . $e->getMessage());
            return [];
        }
    }
    /**
     * Lấy 3 bài viết có lượt xem cao nhất với trạng thái published
     * 
     * @return array|false Mảng chứa thông tin bài viết hoặc false nếu có lỗi
     */
    public function getTopViewedNews($limit = 3)
    {
        try {
            $sql = "SELECT 
                    n.*,
                    nc.name as category_name
                FROM 
                    news n
                LEFT JOIN 
                    news_categories nc ON n.category_id = nc.id
                WHERE 
                    n.status = 'published'
                ORDER BY 
                    n.views DESC
                LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy bài viết xem nhiều nhất: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Tăng lượt xem cho bài viết
     */
    /**
     * Tăng lượt xem cho bài viết
     */
    public function incrementViews($id)
    {
        try {
            $sql = "UPDATE news SET views = views + 1 WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Lỗi khi tăng lượt xem: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Lấy các bài viết liên quan (cùng danh mục, không bao gồm bài hiện tại)
     */
    public function getRelatedNews($categoryId, $currentId, $limit = 4)
    {
        try {
            $sql = "SELECT id, title, featured_image, created_at 
                FROM news 
                WHERE category_id = :category_id 
                AND id != :current_id 
                AND status = 'published'
                ORDER BY created_at DESC 
                LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
            $stmt->bindValue(':current_id', $currentId, \PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy bài viết liên quan: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy bài viết nổi bật (featured) được tạo sớm nhất với trạng thái published
     * 
     * @return array|false Thông tin bài viết hoặc false nếu có lỗi hoặc không tìm thấy
     */
    public function getOldestFeaturedNews()
    {
        try {
            $sql = "SELECT 
                    n.*,
                    nc.name as category_name
                FROM 
                    news n
                LEFT JOIN 
                    news_categories nc ON n.category_id = nc.id
                WHERE 
                    n.featured = 1
                    AND n.status = 'published'
                ORDER BY 
                    n.created_at ASC
                LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy bài viết nổi bật cũ nhất: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy tin tức có bộ lọc (danh mục, tag, tìm kiếm)
     */
    public function getFilteredNews($categoryId = 0, $tag = '', $search = '', $limit = 10, $offset = 0)
    {
        try {
            $conditions = ["n.status = 'published'"];
            $params = [];

            // Lọc theo danh mục
            if ($categoryId > 0) {
                $conditions[] = "n.category_id = :category_id";
                $params[':category_id'] = $categoryId;
            }

            // Lọc theo tag
            if (!empty($tag)) {
                $conditions[] = "n.tags LIKE :tag";
                $params[':tag'] = '%' . $tag . '%';
            }

            // Lọc theo tìm kiếm
            if (!empty($search)) {
                $conditions[] = "(n.title LIKE :search OR n.content LIKE :search OR n.summary LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }

            $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

            $sql = "SELECT n.*, c.name as category_name 
                FROM news n 
                LEFT JOIN news_categories c ON n.category_id = c.id 
                $whereClause 
                ORDER BY n.created_at DESC
                LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Lấy các danh mục cho mỗi bài viết - PHẦN CẦN SỬA
            foreach ($results as $key => $item) {
                // Thay getById() bằng getNewsCategoriesById() để lấy chính xác danh mục
                // getById đang ghi đè toàn bộ thông tin bài viết!
                $results[$key]['categories'] = $this->getNewsCategoriesById($item['id']);
            }

            return $results;
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy tin tức lọc: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy danh mục của một bài viết theo ID
     * Cần thêm phương thức này nếu chưa có
     */
    public function getNewsCategoriesById($newsId)
    {
        try {
            $sql = "SELECT nc.id, nc.name as category_name
                FROM news_categories nc 
                JOIN news_category_relations ncr ON nc.id = ncr.category_id 
                WHERE ncr.news_id = :news_id
                ORDER BY nc.name ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':news_id', $newsId, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy danh mục bài viết: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Đếm tổng số tin tức theo bộ lọc
     */
    public function countFilteredNews($categoryId = 0, $tag = '', $search = '')
    {
        try {
            $conditions = ["status = 'published'"];
            $params = [];

            if ($categoryId > 0) {
                $conditions[] = "category_id = :category_id";
                $params[':category_id'] = $categoryId;
            }

            if (!empty($tag)) {
                $conditions[] = "tags LIKE :tag";
                $params[':tag'] = '%' . $tag . '%';
            }

            if (!empty($search)) {
                $conditions[] = "(title LIKE :search OR content LIKE :search OR summary LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }

            $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

            $sql = "SELECT COUNT(*) as total FROM news $whereClause";

            $stmt = $this->db->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return (int)$result['total'];
        } catch (\Exception $e) {
            error_log("Lỗi khi đếm tin tức: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Lấy bài viết nổi bật
     */
    public function getFeaturedNews()
    {
        try {
            $sql = "SELECT * FROM news 
                WHERE status = 'published' AND is_featured = 1
                ORDER BY created_at DESC
                LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy bài nổi bật: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Lấy tags phổ biến
     */
    public function getPopularTags($limit = 10)
    {
        try {
            $sql = "SELECT DISTINCT TRIM(t.tag) as name, COUNT(n.id) as count
                FROM news n
                JOIN (
                    SELECT id, SUBSTRING_INDEX(SUBSTRING_INDEX(CONCAT(tags, ','), ',', numbers.n), ',', -1) as tag
                    FROM news
                    JOIN (
                        SELECT 1 as n UNION ALL
                        SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                        SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                        SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
                    ) numbers ON CHAR_LENGTH(tags) - CHAR_LENGTH(REPLACE(tags, ',', '')) >= numbers.n - 1
                    WHERE tags IS NOT NULL AND tags != ''
                ) t ON n.id = t.id
                WHERE n.status = 'published'
                GROUP BY TRIM(t.tag)
                ORDER BY count DESC
                LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy tags phổ biến: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy dữ liệu lượt xem tin tức theo tháng cho một năm cụ thể
     * 
     * @param int $year Năm cần lấy dữ liệu (mặc định là năm hiện tại)
     * @return array Mảng dữ liệu với key là tên tháng và value là tổng lượt xem
     */
    public function getMonthlyViewsData($year = null)
    {
        // Nếu không có năm được chỉ định, sử dụng năm hiện tại
        if ($year === null) {
            $year = date('Y');
        }

        try {
            // Lấy dữ liệu lượt xem theo tháng từ CSDL
            $sql = "SELECT 
                    MONTH(created_at) AS month,
                    SUM(views) AS total_views
                FROM 
                    {$this->table}
                WHERE 
                    YEAR(created_at) = :year
                GROUP BY 
                    MONTH(created_at)
                ORDER BY 
                    month ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':year', $year, \PDO::PARAM_INT);
            $stmt->execute();

            $monthlyData = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);

            // Khởi tạo mảng với đủ 12 tháng, giá trị mặc định là 0
            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthName = 'Tháng ' . $i;
                $result[$monthName] = 0;
            }

            // Cập nhật giá trị cho các tháng có dữ liệu
            foreach ($monthlyData as $month => $views) {
                $monthName = 'Tháng ' . $month;
                $result[$monthName] = (int)$views;
            }

            return $result;
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy dữ liệu lượt xem theo tháng: " . $e->getMessage());
            return []; // Trả về mảng rỗng nếu có lỗi
        }
    }

    /**
     * Lấy danh sách các tin tức gần đây
     * 
     * @param int $limit Số lượng tin tức cần lấy
     * @param string|array|null $status Trạng thái của tin tức cần lấy (null để lấy tất cả)
     * @return array Danh sách tin tức gần đây
     */
    public function getRecentNews($limit = 5, $status = null)
    {
        try {
            // Chuẩn bị câu lệnh SQL cơ bản
            $sql = "SELECT 
                    n.id, n.title, n.slug, n.summary, n.featured_image, 
                    n.status, n.views, n.created_at, n.published_at,
                    u.username as author_name
                FROM 
                    {$this->table} n
                LEFT JOIN 
                    users u ON n.created_by = u.id";

            $params = [];

            // Thêm điều kiện lọc theo trạng thái nếu được chỉ định
            if ($status !== null) {
                if (is_array($status)) {
                    // Nếu $status là mảng, sử dụng IN
                    $placeholders = implode(',', array_fill(0, count($status), '?'));
                    $sql .= " WHERE n.status IN ({$placeholders})";
                    $params = array_merge($params, $status);
                } else {
                    // Nếu $status là chuỗi đơn
                    $sql .= " WHERE n.status = ?";
                    $params[] = $status;
                }
            }

            // Sắp xếp theo thời gian tạo giảm dần (mới nhất trước)
            $sql .= " ORDER BY n.created_at DESC";

            // Giới hạn số lượng kết quả
            $sql .= " LIMIT ?";
            $params[] = $limit;

            $stmt = $this->db->prepare($sql);

            // Bind các tham số
            foreach ($params as $i => $param) {
                $paramType = is_int($param) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                $stmt->bindValue($i + 1, $param, $paramType);
            }

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy tin tức gần đây: " . $e->getMessage());
            return []; // Trả về mảng rỗng nếu có lỗi
        }
    }
}
