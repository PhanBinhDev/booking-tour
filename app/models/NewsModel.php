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
}
