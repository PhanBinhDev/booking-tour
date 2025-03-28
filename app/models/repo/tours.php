<?php
/**
 * File: tour_functions.php
 * Các hàm SQL cần thiết cho quản lý Tour
 */

/**
 * =============================
 * CRUD CƠ BẢN CHO TOUR
 * =============================
 */

/**
 * Lấy danh sách tất cả tour
 * 
 * @param int $limit Số lượng tour tối đa
 * @param int $offset Vị trí bắt đầu
 * @param string $status Trạng thái tour (active, inactive, draft, all)
 * @return array Danh sách tour
 */
function getAllTours($limit = 10, $offset = 0, $status = 'active') {
    global $db;
    
    $whereClause = $status !== 'all' ? "WHERE t.status = ?" : "";
    $params = $status !== 'all' ? [$status] : [];
    
    $sql = "
        SELECT 
            t.*,
            tc.name AS category_name,
            l.name AS location_name,
            dl.name AS departure_name,
            CONCAT(u.first_name, ' ', u.last_name) AS created_by_name,
            (SELECT COUNT(*) FROM tour_reviews tr WHERE tr.tour_id = t.id AND tr.status = 'approved') AS review_count,
            (SELECT AVG(rating) FROM tour_reviews tr WHERE tr.tour_id = t.id AND tr.status = 'approved') AS average_rating
        FROM tours t
        LEFT JOIN tour_categories tc ON t.category_id = tc.id
        LEFT JOIN locations l ON t.location_id = l.id
        LEFT JOIN locations dl ON t.departure_location_id = dl.id
        LEFT JOIN users u ON t.created_by = u.id
        $whereClause
        ORDER BY t.created_at DESC
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Lấy tổng số tour
    $countSql = "SELECT COUNT(*) FROM tours t $whereClause";
    $stmt = $db->prepare($countSql);
    $stmt->execute($status !== 'all' ? [$status] : []);
    $totalTours = $stmt->fetchColumn();
    
    return [
        'tours' => $tours,
        'total' => $totalTours,
        'pages' => ceil($totalTours / $limit)
    ];
}

/**
 * Lấy thông tin chi tiết của một tour
 * 
 * @param int $tourId ID của tour
 * @return array|null Thông tin tour
 */
function getTourById($tourId) {
    global $db;
    
    $sql = "
        SELECT 
            t.*,
            tc.name AS category_name,
            l.name AS location_name,
            dl.name AS departure_name,
            CONCAT(u.first_name, ' ', u.last_name) AS created_by_name,
            CONCAT(u2.first_name, ' ', u2.last_name) AS updated_by_name
        FROM tours t
        LEFT JOIN tour_categories tc ON t.category_id = tc.id
        LEFT JOIN locations l ON t.location_id = l.id
        LEFT JOIN locations dl ON t.departure_location_id = dl.id
        LEFT JOIN users u ON t.created_by = u.id
        LEFT JOIN users u2 ON t.updated_by = u2.id
        WHERE t.id = ?
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$tourId]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tour) {
        return null;
    }
    
    // Chuyển đổi JSON thành mảng
    if ($tour['itinerary']) {
        $tour['itinerary'] = json_decode($tour['itinerary'], true);
    }
    
    return $tour;
}

/**
 * Lấy thông tin tour theo slug
 * 
 * @param string $slug Slug của tour
 * @return array|null Thông tin tour
 */
function getTourBySlug($slug) {
    global $db;
    
    $sql = "
        SELECT 
            t.*,
            tc.name AS category_name,
            l.name AS location_name,
            dl.name AS departure_name
        FROM tours t
        LEFT JOIN tour_categories tc ON t.category_id = tc.id
        LEFT JOIN locations l ON t.location_id = l.id
        LEFT JOIN locations dl ON t.departure_location_id = dl.id
        WHERE t.slug = ? AND t.status = 'active'
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$slug]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tour) {
        return null;
    }
    
    // Chuyển đổi JSON thành mảng
    if ($tour['itinerary']) {
        $tour['itinerary'] = json_decode($tour['itinerary'], true);
    }
    
    // Tăng lượt xem
    incrementTourViews($tour['id']);
    
    return $tour;
}

/**
 * Tăng lượt xem cho tour
 * 
 * @param int $tourId ID của tour
 * @return bool Kết quả cập nhật
 */
function incrementTourViews($tourId) {
    global $db;
    
    $sql = "UPDATE tours SET views = views + 1 WHERE id = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$tourId]);
}

/**
 * Tạo tour mới
 * 
 * @param array $tourData Dữ liệu tour
 * @return int|bool ID của tour mới hoặc false nếu thất bại
 */
function createTour($tourData) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Chuẩn bị dữ liệu
        if (isset($tourData['itinerary']) && is_array($tourData['itinerary'])) {
            $tourData['itinerary'] = json_encode($tourData['itinerary']);
        }
        
        // Tạo slug nếu chưa có
        if (empty($tourData['slug'])) {
            $tourData['slug'] = createSlug($tourData['title']);
        }
        
        // Kiểm tra slug đã tồn tại chưa
        $stmt = $db->prepare("SELECT COUNT(*) FROM tours WHERE slug = ?");
        $stmt->execute([$tourData['slug']]);
        if ($stmt->fetchColumn() > 0) {
            $tourData['slug'] = $tourData['slug'] . '-' . time();
        }
        
        $sql = "
            INSERT INTO tours (
                title, slug, description, content, duration, group_size, 
                price, sale_price, featured_image, category_id, location_id, 
                departure_location_id, included, excluded, itinerary, 
                meta_title, meta_description, status, featured, created_by
            ) VALUES (
                :title, :slug, :description, :content, :duration, :group_size, 
                :price, :sale_price, :featured_image, :category_id, :location_id, 
                :departure_location_id, :included, :excluded, :itinerary, 
                :meta_title, :meta_description, :status, :featured, :created_by
            )
        ";
        
        $stmt = $db->prepare($sql);
        
        // Bind các tham số
        $stmt->bindParam(':title', $tourData['title']);
        $stmt->bindParam(':slug', $tourData['slug']);
        $stmt->bindParam(':description', $tourData['description']);
        $stmt->bindParam(':content', $tourData['content']);
        $stmt->bindParam(':duration', $tourData['duration']);
        $stmt->bindParam(':group_size', $tourData['group_size']);
        $stmt->bindParam(':price', $tourData['price']);
        $stmt->bindParam(':sale_price', $tourData['sale_price']);
        $stmt->bindParam(':featured_image', $tourData['featured_image']);
        $stmt->bindParam(':category_id', $tourData['category_id']);
        $stmt->bindParam(':location_id', $tourData['location_id']);
        $stmt->bindParam(':departure_location_id', $tourData['departure_location_id']);
        $stmt->bindParam(':included', $tourData['included']);
        $stmt->bindParam(':excluded', $tourData['excluded']);
        $stmt->bindParam(':itinerary', $tourData['itinerary']);
        $stmt->bindParam(':meta_title', $tourData['meta_title']);
        $stmt->bindParam(':meta_description', $tourData['meta_description']);
        $stmt->bindParam(':status', $tourData['status']);
        $stmt->bindParam(':featured', $tourData['featured'], PDO::PARAM_BOOL);
        $stmt->bindParam(':created_by', $tourData['created_by']);
        
        $stmt->execute();
        $tourId = $db->lastInsertId();
        
        $db->commit();
        return $tourId;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error creating tour: " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật thông tin tour
 * 
 * @param int $tourId ID của tour
 * @param array $tourData Dữ liệu tour cần cập nhật
 * @return bool Kết quả cập nhật
 */
function updateTour($tourId, $tourData) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Chuẩn bị dữ liệu
        if (isset($tourData['itinerary']) && is_array($tourData['itinerary'])) {
            $tourData['itinerary'] = json_encode($tourData['itinerary']);
        }
        
        // Cập nhật slug nếu có thay đổi title và không có slug mới
        if (isset($tourData['title']) && !isset($tourData['slug'])) {
            $tourData['slug'] = createSlug($tourData['title']);
            
            // Kiểm tra slug đã tồn tại chưa (trừ tour hiện tại)
            $stmt = $db->prepare("SELECT COUNT(*) FROM tours WHERE slug = ? AND id != ?");
            $stmt->execute([$tourData['slug'], $tourId]);
            if ($stmt->fetchColumn() > 0) {
                $tourData['slug'] = $tourData['slug'] . '-' . time();
            }
        }
        
        // Xây dựng câu lệnh SQL động
        $updateFields = [];
        $params = [];
        
        foreach ($tourData as $field => $value) {
            $updateFields[] = "$field = :$field";
            $params[":$field"] = $value;
        }
        
        // Thêm updated_by và updated_at
        $updateFields[] = "updated_by = :updated_by";
        $updateFields[] = "updated_at = NOW()";
        $params[":updated_by"] = $tourData['updated_by'];
        
        // Thêm tourId
        $params[":tour_id"] = $tourId;
        
        $sql = "UPDATE tours SET " . implode(', ', $updateFields) . " WHERE id = :tour_id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error updating tour: " . $e->getMessage());
        return false;
    }
}

/**
 * Xóa tour
 * 
 * @param int $tourId ID của tour cần xóa
 * @return bool Kết quả xóa
 */
function deleteTour($tourId) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Xóa các bản ghi liên quan
        $tables = [
            'tour_images',
            'tour_dates',
            'tour_reviews',
            'bookings'
        ];
        
        foreach ($tables as $table) {
            $sql = "DELETE FROM $table WHERE tour_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$tourId]);
        }
        
        // Xóa tour
        $sql = "DELETE FROM tours WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tourId]);
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error deleting tour: " . $e->getMessage());
        return false;
    }
}

/**
 * =============================
 * QUẢN LÝ ẢNH TOUR
 * =============================
 */

/**
 * Lấy tất cả ảnh của tour
 * 
 * @param int $tourId ID của tour
 * @return array Danh sách ảnh
 */
function getTourImages($tourId) {
    global $db;
    
    $sql = "
        SELECT i.*, ti.is_featured, ti.sort_order
        FROM images i
        JOIN tour_images ti ON i.id = ti.image_id
        WHERE ti.tour_id = ?
        ORDER BY ti.is_featured DESC, ti.sort_order ASC
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$tourId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Thêm ảnh cho tour
 * 
 * @param int $tourId ID của tour
 * @param int $imageId ID của ảnh
 * @param bool $isFeatured Có phải ảnh đại diện không
 * @param int $sortOrder Thứ tự sắp xếp
 * @return bool Kết quả thêm
 */
function addTourImage($tourId, $imageId, $isFeatured = false, $sortOrder = 0) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Nếu là ảnh đại diện, cập nhật tất cả ảnh khác không phải đại diện
        if ($isFeatured) {
            $sql = "UPDATE tour_images SET is_featured = 0 WHERE tour_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$tourId]);
            
            // Cập nhật trường featured_image trong bảng tours
            $sql = "
                UPDATE tours t
                SET t.featured_image = (SELECT i.file_path FROM images i WHERE i.id = ?)
                WHERE t.id = ?
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$imageId, $tourId]);
        }
        
        // Thêm ảnh mới
        $sql = "
            INSERT INTO tour_images (tour_id, image_id, is_featured, sort_order)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE is_featured = VALUES(is_featured), sort_order = VALUES(sort_order)
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$tourId, $imageId, $isFeatured, $sortOrder]);
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error adding tour image: " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật thông tin ảnh tour
 * 
 * @param int $tourId ID của tour
 * @param int $imageId ID của ảnh
 * @param array $data Dữ liệu cần cập nhật
 * @return bool Kết quả cập nhật
 */
function updateTourImage($tourId, $imageId, $data) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Nếu cập nhật ảnh đại diện
        if (isset($data['is_featured']) && $data['is_featured']) {
            $sql = "UPDATE tour_images SET is_featured = 0 WHERE tour_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$tourId]);
            
            // Cập nhật trường featured_image trong bảng tours
            $sql = "
                UPDATE tours t
                SET t.featured_image = (SELECT i.file_path FROM images i WHERE i.id = ?)
                WHERE t.id = ?
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$imageId, $tourId]);
        }
        
        // Cập nhật thông tin ảnh
        $updateFields = [];
        $params = [];
        
        foreach ($data as $field => $value) {
            $updateFields[] = "$field = :$field";
            $params[":$field"] = $value;
        }
        
        $params[":tour_id"] = $tourId;
        $params[":image_id"] = $imageId;
        
        $sql = "UPDATE tour_images SET " . implode(', ', $updateFields) . " WHERE tour_id = :tour_id AND image_id = :image_id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error updating tour image: " . $e->getMessage());
        return false;
    }
}

/**
 * Xóa ảnh khỏi tour
 * 
 * @param int $tourId ID của tour
 * @param int $imageId ID của ảnh
 * @param bool $deleteFile Có xóa file ảnh không
 * @return bool Kết quả xóa
 */
function removeTourImage($tourId, $imageId, $deleteFile = false) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Kiểm tra xem ảnh có phải là ảnh đại diện không
        $sql = "SELECT is_featured FROM tour_images WHERE tour_id = ? AND image_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tourId, $imageId]);
        $isFeatured = $stmt->fetchColumn();
        
        // Xóa liên kết ảnh với tour
        $sql = "DELETE FROM tour_images WHERE tour_id = ? AND image_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tourId, $imageId]);
        
        // Nếu là ảnh đại diện, cập nhật ảnh đại diện mới
        if ($isFeatured) {
            // Lấy ảnh đầu tiên còn lại làm ảnh đại diện
            $sql = "
                SELECT ti.image_id, i.file_path
                FROM tour_images ti
                JOIN images i ON ti.image_id = i.id
                WHERE ti.tour_id = ?
                ORDER BY ti.sort_order ASC
                LIMIT 1
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$tourId]);
            $newFeatured = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($newFeatured) {
                // Cập nhật ảnh đại diện mới
                $sql = "UPDATE tour_images SET is_featured = 1 WHERE tour_id = ? AND image_id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$tourId, $newFeatured['image_id']]);
                
                // Cập nhật trường featured_image trong bảng tours
                $sql = "UPDATE tours SET featured_image = ? WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$newFeatured['file_path'], $tourId]);
            } else {
                // Không còn ảnh nào, xóa featured_image
                $sql = "UPDATE tours SET featured_image = NULL WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$tourId]);
            }
        }
        
        // Xóa file ảnh nếu cần
        if ($deleteFile) {
            $sql = "SELECT file_path FROM images WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$imageId]);
            $filePath = $stmt->fetchColumn();
            
            if ($filePath && file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Xóa bản ghi ảnh
            $sql = "DELETE FROM images WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$imageId]);
        }
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error removing tour image: " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật thứ tự sắp xếp của ảnh tour
 * 
 * @param int $tourId ID của tour
 * @param array $imageOrder Mảng ID ảnh theo thứ tự mới
 * @return bool Kết quả cập nhật
 */
function updateTourImageOrder($tourId, $imageOrder) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        foreach ($imageOrder as $index => $imageId) {
            $sql = "UPDATE tour_images SET sort_order = ? WHERE tour_id = ? AND image_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$index, $tourId, $imageId]);
        }
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error updating tour image order: " . $e->getMessage());
        return false;
    }
}

/**
 * =============================
 * TÌM KIẾM VÀ LỌC TOUR
 * =============================
 */

/**
 * Tìm kiếm tour với nhiều điều kiện
 * 
 * @param array $filters Các điều kiện lọc
 * @param int $limit Số lượng tour tối đa
 * @param int $offset Vị trí bắt đầu
 * @return array Danh sách tour
 */
function searchTours($filters = [], $limit = 10, $offset = 0) {
    global $db;
    
    // Xây dựng câu lệnh WHERE
    $whereConditions = ["t.status = 'active'"];
    $params = [];
    
    // Lọc theo từ khóa
    if (!empty($filters['keyword'])) {
        $whereConditions[] = "(t.title LIKE ? OR t.description LIKE ? OR t.content LIKE ?)";
        $keyword = "%" . $filters['keyword'] . "%";
        $params[] = $keyword;
        $params[] = $keyword;
        $params[] = $keyword;
    }
    
    // Lọc theo danh mục
    if (!empty($filters['category_id'])) {
        $whereConditions[] = "t.category_id = ?";
        $params[] = $filters['category_id'];
    }
    
    // Lọc theo địa điểm
    if (!empty($filters['location_id'])) {
        $whereConditions[] = "t.location_id = ?";
        $params[] = $filters['location_id'];
    }
    
    // Lọc theo điểm khởi hành
    if (!empty($filters['departure_id'])) {
        $whereConditions[] = "t.departure_location_id = ?";
        $params[] = $filters['departure_id'];
    }
    
    // Lọc theo khoảng giá
    if (!empty($filters['price_min'])) {
        $whereConditions[] = "t.price >= ?";
        $params[] = $filters['price_min'];
    }
    
    if (!empty($filters['price_max'])) {
        $whereConditions[] = "t.price <= ?";
        $params[] = $filters['price_max'];
    }
    
    // Lọc theo thời gian
    if (!empty($filters['duration'])) {
        $whereConditions[] = "t.duration LIKE ?";
        $params[] = "%" . $filters['duration'] . "%";
    }
    
    // Lọc theo đánh giá
    if (!empty($filters['rating_min'])) {
        $whereConditions[] = "(SELECT AVG(rating) FROM tour_reviews tr WHERE tr.tour_id = t.id AND tr.status = 'approved') >= ?";
        $params[] = $filters['rating_min'];
    }
    
    // Lọc tour nổi bật
    if (isset($filters['featured']) && $filters['featured']) {
        $whereConditions[] = "t.featured = 1";
    }
    
    // Xây dựng câu lệnh WHERE
    $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
    
    // Xây dựng câu lệnh ORDER BY
    $orderBy = "t.created_at DESC";
    if (!empty($filters['sort_by'])) {
        switch ($filters['sort_by']) {
            case 'price_asc':
                $orderBy = "t.price ASC";
                break;
            case 'price_desc':
                $orderBy = "t.price DESC";
                break;
            case 'rating':
                $orderBy = "(SELECT AVG(rating) FROM tour_reviews tr WHERE tr.tour_id = t.id AND tr.status = 'approved') DESC";
                break;
            case 'popularity':
                $orderBy = "t.views DESC";
                break;
            case 'newest':
                $orderBy = "t.created_at DESC";
                break;
        }
    }
    
    // Lấy tổng số tour thỏa mãn điều kiện
    $countSql = "SELECT COUNT(*) FROM tours t $whereClause";
    $stmt = $db->prepare($countSql);
    $stmt->execute($params);
    $totalTours = $stmt->fetchColumn();
    
    // Lấy danh sách tour
    $sql = "
        SELECT 
            t.*,
            tc.name AS category_name,
            l.name AS location_name,
            dl.name AS departure_name,
            (SELECT COUNT(*) FROM tour_reviews tr WHERE tr.tour_id = t.id AND tr.status = 'approved') AS review_count,
            (SELECT AVG(rating) FROM tour_reviews tr WHERE tr.tour_id = t.id AND tr.status = 'approved') AS average_rating
        FROM tours t
        LEFT JOIN tour_categories tc ON t.category_id = tc.id
        LEFT JOIN locations l ON t.location_id = l.id
        LEFT JOIN locations dl ON t.departure_location_id = dl.id
        $whereClause
        ORDER BY $orderBy
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Lấy ảnh đại diện cho mỗi tour
    foreach ($tours as &$tour) {
        $tour['featured_image_object'] = getFeaturedImageForTour($tour['id']);
    }
    
    return [
        'tours' => $tours,
        'total' => $totalTours,
        'pages' => ceil($totalTours / $limit)
    ];
}

/**
 * Lấy ảnh đại diện cho tour
 * 
 * @param int $tourId ID của tour
 * @return array|null Thông tin ảnh đại diện
 */
function getFeaturedImageForTour($tourId) {
    global $db;
    
    $sql = "
        SELECT i.*
        FROM images i
        JOIN tour_images ti ON i.id = ti.image_id
        WHERE ti.tour_id = ? AND ti.is_featured = 1
        LIMIT 1
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$tourId]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$image) {
        // Nếu không tìm thấy ảnh đại diện, lấy ảnh đầu tiên
        $sql = "
            SELECT i.*
            FROM images i
            JOIN tour_images ti ON i.id = ti.image_id
            WHERE ti.tour_id = ?
            ORDER BY ti.sort_order ASC
            LIMIT 1
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$tourId]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return $image;
}

/**
 * Lấy danh sách tour liên quan
 * 
 * @param int $tourId ID của tour hiện tại
 * @param int $limit Số lượng tour tối đa
 * @return array Danh sách tour liên quan
 */
function getRelatedTours($tourId, $limit = 4) {
    global $db;
    
    // Lấy thông tin tour hiện tại
    $sql = "SELECT category_id, location_id FROM tours WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$tourId]);
    $currentTour = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$currentTour) {
        return [];
    }
    
    // Lấy tour cùng danh mục hoặc cùng địa điểm
    $whereConditions = ["t.id != ? AND t.status = 'active'"];
    $params = [$tourId];
    
    if ($currentTour['category_id']) {
        $whereConditions[] = "t.category_id = ?";
        $params[] = $currentTour['category_id'];
    }
    
    if ($currentTour['location_id']) {
        $whereConditions[] = "t.location_id = ?";
        $params[] = $currentTour['location_id'];
    }
    
    $whereClause = implode(" OR ", array_map(function($condition) {
        return "($condition)";
    }, array_slice($whereConditions, 1)));
    
    if ($whereClause) {
        $whereClause = $whereConditions[0] . " AND (" . $whereClause . ")";
    } else {
        $whereClause = $whereConditions[0];
    }
    
    $sql = "
        SELECT 
            t.*,
            tc.name AS category_name,
            l.name AS location_name,
            (SELECT AVG(rating) FROM tour_reviews tr WHERE tr.tour_id = t.id AND tr.status = 'approved') AS average_rating
        FROM tours t
        LEFT JOIN tour_categories tc ON t.category_id = tc.id
        LEFT JOIN locations l ON t.location_id = l.id
        WHERE $whereClause
        ORDER BY t.featured DESC, t.views DESC
        LIMIT ?
    ";
    
    $params[] = $limit;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Lấy ảnh đại diện cho mỗi tour
    foreach ($tours as &$tour) {
        $tour['featured_image_object'] = getFeaturedImageForTour($tour['id']);
    }
    
    return $tours;
}

/**
 * =============================
 * QUẢN LÝ LỊCH TRÌNH TOUR
 * =============================
 */

/**
 * Lấy lịch trình chi tiết của tour
 * 
 * @param int $tourId ID của tour
 * @return array Lịch trình tour
 */
function getTourItinerary($tourId) {
    global $db;
    
    $sql = "SELECT itinerary FROM tours WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$tourId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result || !$result['itinerary']) {
        return [];
    }
    
    return json_decode($result['itinerary'], true);
}

/**
 * Cập nhật lịch trình tour
 * 
 * @param int $tourId ID của tour
 * @param array $itinerary Lịch trình mới
 * @param int $updatedBy ID người cập nhật
 * @return bool Kết quả cập nhật
 */
function updateTourItinerary($tourId, $itinerary, $updatedBy) {
    global $db;
    
    try {
        $sql = "
            UPDATE tours 
            SET itinerary = ?, updated_by = ?, updated_at = NOW() 
            WHERE id = ?
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([json_encode($itinerary), $updatedBy, $tourId]);
        
        return true;
    } catch (Exception $e) {
        error_log("Error updating tour itinerary: " . $e->getMessage());
        return false;
    }
}

/**
 * =============================
 * QUẢN LÝ NGÀY KHỞI HÀNH TOUR
 * =============================
 */

/**
 * Lấy danh sách ngày khởi hành của tour
 * 
 * @param int $tourId ID của tour
 * @param bool $onlyAvailable Chỉ lấy ngày còn chỗ
 * @return array Danh sách ngày khởi hành
 */
function getTourDates($tourId, $onlyAvailable = false) {
    global $db;
    
    $whereClause = $onlyAvailable ? "AND td.status = 'available' AND td.start_date >= CURDATE()" : "";
    
    $sql = "
        SELECT td.*
        FROM tour_dates td
        WHERE td.tour_id = ? $whereClause
        ORDER BY td.start_date ASC
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$tourId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Thêm ngày khởi hành mới cho tour
 * 
 * @param int $tourId ID của tour
 * @param array $dateData Dữ liệu ngày khởi hành
 * @return int|bool ID của ngày khởi hành mới hoặc false nếu thất bại
 */
function addTourDate($tourId, $dateData) {
    global $db;
    
    try {
        $sql = "
            INSERT INTO tour_dates (
                tour_id, start_date, end_date, price, sale_price, available_seats, status
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?
            )
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $tourId,
            $dateData['start_date'],
            $dateData['end_date'],
            $dateData['price'],
            $dateData['sale_price'],
            $dateData['available_seats'],
            $dateData['status']
        ]);
        
        return $db->lastInsertId();
    } catch (Exception $e) {
        error_log("Error adding tour date: " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật ngày khởi hành
 * 
 * @param int $dateId ID của ngày khởi hành
 * @param array $dateData Dữ liệu cần cập nhật
 * @return bool Kết quả cập nhật
 */
function updateTourDate($dateId, $dateData) {
    global $db;
    
    try {
        // Xây dựng câu lệnh SQL động
        $updateFields = [];
        $params = [];
        
        foreach ($dateData as $field => $value) {
            $updateFields[] = "$field = :$field";
            $params[":$field"] = $value;
        }
        
        $params[":date_id"] = $dateId;
        
        $sql = "UPDATE tour_dates SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = :date_id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        return true;
    } catch (Exception $e) {
        error_log("Error updating tour date: " . $e->getMessage());
        return false;
    }
}

/**
 * Xóa ngày khởi hành
 * 
 * @param int $dateId ID của ngày khởi hành
 * @return bool Kết quả xóa
 */
function deleteTourDate($dateId) {
    global $db;
    
    try {
        // Kiểm tra xem có đơn đặt tour nào cho ngày này không
        $sql = "SELECT COUNT(*) FROM bookings WHERE tour_date_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$dateId]);
        
        if ($stmt->fetchColumn() > 0) {
            // Có đơn đặt tour, chỉ cập nhật trạng thái thành cancelled
            $sql = "UPDATE tour_dates SET status = 'cancelled', updated_at = NOW() WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$dateId]);
        } else {
            // Không có đơn đặt tour, xóa hoàn toàn
            $sql = "DELETE FROM tour_dates WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$dateId]);
        }
        
        return true;
    } catch (Exception $e) {
        error_log("Error deleting tour date: " . $e->getMessage());
        return false;
    }
}

/**
 * =============================
 * QUẢN LÝ ĐẶT TOUR
 * =============================
 */

/**
 * Lấy danh sách đơn đặt tour
 * 
 * @param array $filters Các điều kiện lọc
 * @param int $limit Số lượng đơn tối đa
 * @param int $offset Vị trí bắt đầu
 * @return array Danh sách đơn đặt tour
 */
function getBookings($filters = [], $limit = 10, $offset = 0) {
    global $db;
    
    // Xây dựng câu lệnh WHERE
    $whereConditions = [];
    $params = [];
    
    if (!empty($filters['tour_id'])) {
        $whereConditions[] = "b.tour_id = ?";
        $params[] = $filters['tour_id'];
    }
    
    if (!empty($filters['user_id'])) {
        $whereConditions[] = "b.user_id = ?";
        $params[] = $filters['user_id'];
    }
    
    if (!empty($filters['status'])) {
        $whereConditions[] = "b.status = ?";
        $params[] = $filters['status'];
    }
    
    if (!empty($filters['payment_status'])) {
        $whereConditions[] = "b.payment_status = ?";
        $params[] = $filters['payment_status'];
    }
    
    if (!empty($filters['date_from'])) {
        $whereConditions[] = "b.created_at >= ?";
        $params[] = $filters['date_from'] . ' 00:00:00';
    }
    
    if (!empty($filters['date_to'])) {
        $whereConditions[] = "b.created_at <= ?";
        $params[] = $filters['date_to'] . ' 23:59:59';
    }
    
    if (!empty($filters['booking_number'])) {
        $whereConditions[] = "b.booking_number LIKE ?";
        $params[] = '%' . $filters['booking_number'] . '%';
    }
    
    $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
    
    // Lấy tổng số đơn đặt tour
    $countSql = "SELECT COUNT(*) FROM bookings b $whereClause";
    $stmt = $db->prepare($countSql);
    $stmt->execute($params);
    $totalBookings = $stmt->fetchColumn();
    
    // Lấy danh sách đơn đặt tour
    $sql = "
        SELECT 
            b.*,
            t.title AS tour_title,
            t.slug AS tour_slug,
            u.username,
            u.email,
            u.full_name,
            td.start_date,
            td.end_date
        FROM bookings b
        LEFT JOIN tours t ON b.tour_id = t.id
        LEFT JOIN users u ON b.user_id = u.id
        LEFT JOIN tour_dates td ON b.tour_date_id = td.id
        $whereClause
        ORDER BY b.created_at DESC
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return [
        'bookings' => $bookings,
        'total' => $totalBookings,
        'pages' => ceil($totalBookings / $limit)
    ];
}

/**
 * Lấy thông tin chi tiết đơn đặt tour
 * 
 * @param int $bookingId ID của đơn đặt tour
 * @return array|null Thông tin đơn đặt tour
 */
function getBookingById($bookingId) {
    global $db;
    
    $sql = "
        SELECT 
            b.*,
            t.title AS tour_title,
            t.slug AS tour_slug,
            t.featured_image AS tour_image,
            u.username,
            u.email AS user_email,
            u.full_name AS user_name,
            u.phone AS user_phone,
            td.start_date,
            td.end_date
        FROM bookings b
        LEFT JOIN tours t ON b.tour_id = t.id
        LEFT JOIN users u ON b.user_id = u.id
        LEFT JOIN tour_dates td ON b.tour_date_id = td.id
        WHERE b.id = ?
    ";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$bookingId]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$booking) {
        return null;
    }
    
    // Lấy danh sách khách hàng trong đơn
    $sql = "SELECT * FROM booking_customers WHERE booking_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$bookingId]);
    $booking['customers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $booking;
}

/**
 * Lấy thông tin đơn đặt tour theo mã đặt tour
 * 
 * @param string $bookingNumber Mã đặt tour
 * @return array|null Thông tin đơn đặt tour
 */
function getBookingByNumber($bookingNumber) {
    global $db;
    
    $sql = "SELECT id FROM bookings WHERE booking_number = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$bookingNumber]);
    $bookingId = $stmt->fetchColumn();
    
    if (!$bookingId) {
        return null;
    }
    
    return getBookingById($bookingId);
}

/**
 * Tạo đơn đặt tour mới
 * 
 * @param array $bookingData Dữ liệu đơn đặt tour
 * @param array $customers Danh sách khách hàng
 * @return int|bool ID của đơn đặt tour mới hoặc false nếu thất bại
 */
function createBooking($bookingData, $customers) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Tạo mã đặt tour
        $bookingNumber = generateBookingNumber();
        
        // Thêm đơn đặt tour
        $sql = "
            INSERT INTO bookings (
                booking_number, user_id, tour_id, tour_date_id, adults, children,
                total_price, status, payment_status, payment_method, special_requirements
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $bookingNumber,
            $bookingData['user_id'],
            $bookingData['tour_id'],
            $bookingData['tour_date_id'],
            $bookingData['adults'],
            $bookingData['children'],
            $bookingData['total_price'],
            $bookingData['status'] ?? 'pending',
            $bookingData['payment_status'] ?? 'pending',
            $bookingData['payment_method'] ?? null,
            $bookingData['special_requirements'] ?? null
        ]);
        
        $bookingId = $db->lastInsertId();
        
        // Thêm thông tin khách hàng
        $sql = "
            INSERT INTO booking_customers (
                booking_id, full_name, email, phone, address, 
                passport_number, date_of_birth, nationality, type
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";
        
        $stmt = $db->prepare($sql);
        
        foreach ($customers as $customer) {
            $stmt->execute([
                $bookingId,
                $customer['full_name'],
                $customer['email'] ?? null,
                $customer['phone'] ?? null,
                $customer['address'] ?? null,
                $customer['passport_number'] ?? null,
                $customer['date_of_birth'] ?? null,
                $customer['nationality'] ?? null,
                $customer['type'] ?? 'adult'
            ]);
        }
        
        // Cập nhật số chỗ còn trống
        if (!empty($bookingData['tour_date_id'])) {
            $sql = "
                UPDATE tour_dates 
                SET available_seats = available_seats - ?, 
                    status = CASE WHEN available_seats - ? <= 0 THEN 'full' ELSE status END
                WHERE id = ?
            ";
            
            $totalPeople = $bookingData['adults'] + $bookingData['children'];
            $stmt = $db->prepare($sql);
            $stmt->execute([$totalPeople, $totalPeople, $bookingData['tour_date_id']]);
        }
        
        $db->commit();
        return $bookingId;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error creating booking: " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật trạng thái đơn đặt tour
 * 
 * @param int $bookingId ID của đơn đặt tour
 * @param string $status Trạng thái mới
 * @param string $paymentStatus Trạng thái thanh toán mới (nếu có)
 * @return bool Kết quả cập nhật
 */
function updateBookingStatus($bookingId, $status, $paymentStatus = null) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Lấy thông tin đơn đặt tour
        $sql = "SELECT tour_date_id, adults, children, status FROM bookings WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bookingId]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$booking) {
            return false;
        }
        
        // Cập nhật trạng thái đơn
        $sql = "UPDATE bookings SET status = ?, updated_at = NOW()";
        $params = [$status];
        
        if ($paymentStatus) {
            $sql .= ", payment_status = ?";
            $params[] = $paymentStatus;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $bookingId;
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        // Nếu hủy đơn, cập nhật lại số chỗ còn trống
        if ($status === 'cancelled' && $booking['status'] !== 'cancelled' && $booking['tour_date_id']) {
            $totalPeople = $booking['adults'] + $booking['children'];
            
            $sql = "
                UPDATE tour_dates 
                SET available_seats = available_seats + ?, 
                    status = 'available'
                WHERE id = ?
            ";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([$totalPeople, $booking['tour_date_id']]);
        }
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Error updating booking status: " . $e->getMessage());
        return false;
    }
}

/**
 * Tạo mã đặt tour ngẫu nhiên
 * 
 * @return string Mã đặt tour
 */
function generateBookingNumber() {
    $prefix = 'DT';
    $timestamp = date('ymd');
    $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
    
    return $prefix . $timestamp . $random;
}

/**
 * =============================
 * QUẢN LÝ ĐÁNH GIÁ TOUR
 * =============================
 */

/**
 * Lấy danh sách đánh giá của tour
 * 
 * @param int $tourId ID của tour
 * @param string $status Trạng thái đánh giá (approved, pending, rejected, all)
 * @param int $limit Số lượng đánh giá tối đa
 * @param int $offset Vị trí bắt đầu
 * @return array Danh sách đánh giá
 */
function getTourReviews($tourId, $status = 'approved', $limit = 10, $offset = 0) {
    global $db;
    
    $whereClause = "WHERE tr.tour_id = ?";
    $params = [$tourId];
    
    if ($status !== 'all') {
        $whereClause .= " AND tr.status = ?";
        $params[] = $status;
    }
    
    // Lấy tổng số đánh giá
    $countSql = "SELECT COUNT(*) FROM tour_reviews tr $whereClause";
    $stmt = $db->prepare($countSql);
    $stmt->execute($params);
    $totalReviews = $stmt->fetchColumn();
    
    // Lấy danh sách đánh giá
    $sql = "
        SELECT 
            tr.*,
            u.username,
            u.full_name,
            u.avatar
        FROM tour_reviews tr
        LEFT JOIN users u ON tr.user_id = u.id
        $whereClause
        ORDER BY tr.created_at DESC
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return [
        'reviews' => $reviews,
        'total' => $totalReviews,
        'pages' => ceil($totalReviews / $limit)
    ];
}

/**
 * Thêm đánh giá mới
 * 
 * @param array $reviewData Dữ liệu đánh giá
 * @return int|bool ID của đánh giá mới hoặc false nếu thất bại
 */
function addTourReview($reviewData) {
    global $db;
    
    try {
        // Kiểm tra xem người dùng đã đánh giá tour này chưa
        $sql = "SELECT COUNT(*) FROM tour_reviews WHERE tour_id = ? AND user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$reviewData['tour_id'], $reviewData['user_id']]);
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Đã đánh giá rồi
        }
        
        // Kiểm tra xem người dùng đã đặt tour này chưa
        if (!empty($reviewData['booking_id'])) {
            $sql = "SELECT COUNT(*) FROM bookings WHERE id = ? AND user_id = ? AND tour_id = ? AND status = 'completed'";
            $stmt = $db->prepare($sql);
            $stmt->execute([$reviewData['booking_id'], $reviewData['user_id'], $reviewData['tour_id']]);
            
            if ($stmt->fetchColumn() === 0) {
                return false; // Không tìm thấy đơn đặt tour hoặc chưa hoàn thành
            }
        }
        
        // Thêm đánh giá mới
        $sql = "
            INSERT INTO tour_reviews (
                tour_id, user_id, booking_id, rating, title, review, status
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?
            )
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $reviewData['tour_id'],
            $reviewData['user_id'],
            $reviewData['booking_id'] ?? null,
            $reviewData['rating'],
            $reviewData['title'] ?? null,
            $reviewData['review'],
            $reviewData['status'] ?? 'pending'
        ]);
        
        return $db->lastInsertId();
    } catch (Exception $e) {
        error_log("Error adding tour review: " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật trạng thái đánh giá
 * 
 * @param int $reviewId ID của đánh giá
 * @param string $status Trạng thái mới
 * @return bool Kết quả cập nhật
 */
function updateReviewStatus($reviewId, $status) {
    global $db;
    
    try {
        $sql = "UPDATE tour_reviews SET status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$status, $reviewId]);
        
        return true;
    } catch (Exception $e) {
        error_log("Error updating review status: " . $e->getMessage());
        return false;
    }
}

/**
 * Xóa đánh giá
 * 
 * @param int $reviewId ID của đánh giá
 * @return bool Kết quả xóa
 */
function deleteReview($reviewId) {
    global $db;
    
    try {
        $sql = "DELETE FROM tour_reviews WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$reviewId]);
        
        return true;
    } catch (Exception $e) {
        error_log("Error deleting review: " . $e->getMessage());
        return false;
    }
}

/**
 * =============================
 * THỐNG KÊ VÀ BÁO CÁO
 * =============================
 */

/**
 * Lấy thống kê tổng quan
 * 
 * @return array Dữ liệu thống kê
 */
function getDashboardStats() {
    global $db;
    
    try {
        $stats = [];
        
        // Tổng số tour
        $sql = "SELECT COUNT(*) FROM tours WHERE status = 'active'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stats['total_tours'] = $stmt->fetchColumn();
        
        // Tổng số đơn đặt tour
        $sql = "SELECT COUNT(*) FROM bookings";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stats['total_bookings'] = $stmt->fetchColumn();
        
        // Tổng doanh thu
        $sql = "SELECT SUM(total_price) FROM bookings WHERE status != 'cancelled' AND payment_status = 'paid'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetchColumn() ?: 0;
        
        // Đơn đặt tour mới trong tháng
        $sql = "SELECT COUNT(*) FROM bookings WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stats['monthly_bookings'] = $stmt->fetchColumn();
        
        // Doanh thu trong tháng
        $sql = "SELECT SUM(total_price) FROM bookings WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status != 'cancelled' AND payment_status = 'paid'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stats['monthly_revenue'] = $stmt->fetchColumn() ?: 0;
        
        // Tour phổ biến nhất
        $sql = "
            SELECT 
                t.id, t.title, t.slug, t.featured_image,
                COUNT(b.id) AS booking_count
            FROM tours t
            JOIN bookings b ON t.id = b.tour_id
            WHERE b.status != 'cancelled'
            GROUP BY t.id
            ORDER BY booking_count DESC
            LIMIT 5
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stats['popular_tours'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Đơn đặt tour gần đây
        $sql = "
            SELECT 
                b.id, b.booking_number, b.total_price, b.status, b.created_at,
                t.title AS tour_title,
                u.full_name AS customer_name
            FROM bookings b
            JOIN tours t ON b.tour_id = t.id
            LEFT JOIN users u ON b.user_id = u.id
            ORDER BY b.created_at DESC
            LIMIT 5
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stats['recent_bookings'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $stats;
    } catch (Exception $e) {
        error_log("Error getting dashboard stats: " . $e->getMessage());
        return [];
    }
}

/**
 * Lấy báo cáo doanh thu theo khoảng thời gian
 * 
 * @param string $startDate Ngày bắt đầu (Y-m-d)
 * @param string $endDate Ngày kết thúc (Y-m-d)
 * @param string $groupBy Nhóm theo (day, month, year)
 * @return array Dữ liệu báo cáo
 */
function getRevenueReport($startDate, $endDate, $groupBy = 'day') {
    global $db;
    
    try {
        $format = '';
        $groupByClause = '';
        
        switch ($groupBy) {
            case 'day':
                $format = '%Y-%m-%d';
                $groupByClause = 'DATE(created_at)';
                break;
            case 'month':
                $format = '%Y-%m';
                $groupByClause = 'YEAR(created_at), MONTH(created_at)';
                break;
            case 'year':
                $format = '%Y';
                $groupByClause = 'YEAR(created_at)';
                break;
            default:
                $format = '%Y-%m-%d';
                $groupByClause = 'DATE(created_at)';
        }
        
        $sql = "
            SELECT 
                DATE_FORMAT(created_at, '$format') AS period,
                COUNT(*) AS booking_count,
                SUM(total_price) AS total_revenue,
                SUM(CASE WHEN payment_status = 'paid' THEN total_price ELSE 0 END) AS paid_revenue,
                SUM(CASE WHEN status = 'cancelled' THEN total_price ELSE 0 END) AS cancelled_amount
            FROM bookings
            WHERE created_at BETWEEN ? AND ?
            GROUP BY $groupByClause
            ORDER BY period ASC
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error getting revenue report: " . $e->getMessage());
        return [];
    }
}

/**
 * Lấy báo cáo tour phổ biến
 * 
 * @param string $startDate Ngày bắt đầu (Y-m-d)
 * @param string $endDate Ngày kết thúc (Y-m-d)
 * @param int $limit Số lượng tour tối đa
 * @return array Dữ liệu báo cáo
 */
function getPopularToursReport($startDate, $endDate, $limit = 10) {
    global $db;
    
    try {
        $sql = "
            SELECT 
                t.id, t.title, t.slug, t.featured_image,
                COUNT(b.id) AS booking_count,
                SUM(b.total_price) AS total_revenue,
                AVG(tr.rating) AS average_rating
            FROM tours t
            LEFT JOIN bookings b ON t.id = b.tour_id AND b.created_at BETWEEN ? AND ? AND b.status != 'cancelled'
            LEFT JOIN tour_reviews tr ON t.id = tr.tour_id AND tr.status = 'approved'
            GROUP BY t.id
            ORDER BY booking_count DESC, total_revenue DESC
            LIMIT ?
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59', $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error getting popular tours report: " . $e->getMessage());
        return [];
    }
}

/**
 * =============================
 * TIỆN ÍCH
 * =============================
 */

/**
 * Tạo slug từ chuỗi
 * 
 * @param string $string Chuỗi cần tạo slug
 * @return string Slug
 */
function createSlug($string) {
    // Chuyển đổi sang chữ thường
    $string = mb_strtolower($string, 'UTF-8');
    
    // Chuyển đổi các ký tự có dấu sang không dấu
    $string = removeAccents($string);
    
    // Thay thế các ký tự không phải chữ cái và số bằng dấu gạch ngang
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    
    // Xóa dấu gạch ngang ở đầu và cuối
    $string = trim($string, '-');
    
    return $string;
}

/**
 * Xóa dấu tiếng Việt
 * 
 * @param string $string Chuỗi cần xóa dấu
 * @return string Chuỗi không dấu
 */
function removeAccents($string) {
    $search = array(
        'à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ằ', 'ắ', 'ẳ', 'ẵ', 'ặ', 'â', 'ầ', 'ấ', 'ẩ', 'ẫ', 'ậ',
        'đ',
        'è', 'é', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ề', 'ế', 'ể', 'ễ', 'ệ',
        'ì', 'í', 'ỉ', 'ĩ', 'ị',
        'ò', 'ó', 'ỏ', 'õ', 'ọ', 'ô', 'ồ', 'ố', 'ổ', 'ỗ', 'ộ', 'ơ', 'ờ', 'ớ', 'ở', 'ỡ', 'ợ',
        'ù', 'ú', 'ủ', 'ũ', 'ụ', 'ư', 'ừ', 'ứ', 'ử', 'ữ', 'ự',
        'ỳ', 'ý', 'ỷ', 'ỹ', 'ỵ'
    );
    
    $replace = array(
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'd',
        'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
        'i', 'i', 'i', 'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
        'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
        'y', 'y', 'y', 'y', 'y'
    );
    
    return str_replace($search, $replace, $string);
}

/**
 * Định dạng giá tiền
 * 
 * @param float $price Giá tiền
 * @param string $currency Đơn vị tiền tệ
 * @return string Giá tiền đã định dạng
 */
function formatPrice($price, $currency = 'VND') {
    if ($currency === 'VND') {
        return number_format($price, 0, ',', '.') . ' ₫';
    } else {
        return number_format($price, 2, '.', ',') . ' ' . $currency;
    }
}

/**
 * Tính giá khuyến mãi
 * 
 * @param float $price Giá gốc
 * @param float $salePrice Giá khuyến mãi
 * @return array Thông tin giá và phần trăm giảm
 */
function calculateDiscount($price, $salePrice) {
    if (!$salePrice || $salePrice >= $price) {
        return [
            'original_price' => $price,
            'sale_price' => null,
            'discount_percent' => 0,
            'discount_amount' => 0
        ];
    }
    
    $discountAmount = $price - $salePrice;
    $discountPercent = round(($discountAmount / $price) * 100);
    
    return [
        'original_price' => $price,
        'sale_price' => $salePrice,
        'discount_percent' => $discountPercent,
        'discount_amount' => $discountAmount
    ];
}

/**
 * Tính số ngày giữa hai ngày
 * 
 * @param string $startDate Ngày bắt đầu
 * @param string $endDate Ngày kết thúc
 * @return int Số ngày
 */
function calculateDays($startDate, $endDate) {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = $start->diff($end);
    
    return $interval->days + 1; // +1 để tính cả ngày đầu và cuối
}

/**
 * Kiểm tra quyền truy cập tour
 * 
 * @param int $userId ID người dùng
 * @param int $tourId ID tour
 * @return bool Có quyền không
 */
function canAccessTour($userId, $tourId) {
    global $db;
    
    // Kiểm tra xem người dùng có phải là người tạo tour không
    $sql = "SELECT created_by FROM tours WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$tourId]);
    $createdBy = $stmt->fetchColumn();
    
    if ($createdBy === $userId) {
        return true;
    }
    
    // Kiểm tra quyền
    return hasPermission($userId, PERM_EDIT_TOURS);
}