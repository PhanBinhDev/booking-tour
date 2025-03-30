<?php

namespace App\Models;

use App\Config\Database;
use PDO;

abstract class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        global $db;
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function deleteSoft($id)
    {
        $sql = "UPDATE {$this->table} SET isDeleted = '1' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    /**
     * Lấy tất cả bản ghi
     * 
     * @param array $conditions Điều kiện lọc
     * @param string $orderBy Sắp xếp theo
     * @param int $limit Giới hạn số bản ghi
     * @param int $offset Vị trí bắt đầu
     * @return array Danh sách bản ghi
     */
    public function getAll($columns = "*", $conditions = [], $orderBy = 'id DESC', $limit = null, $offset = null, $joins = [], $groupBy = '')
    {
        $sql = "SELECT {$columns} FROM {$this->table}";

        if (!empty($joins)) {
            foreach ($joins as $join) {
                $sql .= " " . $join;
            }
        }

        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereClauses = [];

            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = :$key";
            }

            $sql .= implode(' AND ', $whereClauses);
        }

        if (!empty($groupBy)) {
            $sql .= " " . $groupBy;
        }

        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }

        if ($limit !== null) {
            $sql .= " LIMIT :limit";

            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }

        $stmt = $this->db->prepare($sql);

        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

            if ($offset !== null) {
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get paginated records with optional filters, joins, and sorting
     * 
     * @param array $options Array of options including:
     *      - columns: string|array Columns to select (default: "*")
     *      - joins: array Array of join statements
     *      - filters: array Filter conditions as key-value pairs
     *      - sort: string Field to sort by (default: "created_at")
     *      - direction: string Sort direction (asc or desc, default: "desc")
     *      - page: int Page number (default: 1)
     *      - limit: int Records per page (default: 10)
     *      - additional_where: string Additional raw WHERE clauses
     *      - group_by: string GROUP BY clause
     *      - search_term: string Search term for LIKE queries
     *      - search_fields: array Fields to search in for LIKE queries
     * @return array Paginated records with pagination metadata
     */
    public function getPaginatedCustom($options = [])
    {
        // Extract options with defaults
        $columns = $options['columns'] ?? "*";
        $joins = $options['joins'] ?? [];
        $filters = $options['filters'] ?? [];
        $sort = $options['sort'] ?? "created_at";
        $direction = strtolower($options['direction'] ?? "desc");
        $page = max(1, $options['page'] ?? 1);
        $limit = max(1, $options['limit'] ?? 10);
        $additionalWhere = $options['additional_where'] ?? "";
        $groupBy = $options['group_by'] ?? "";
        $searchTerm = $options['search_term'] ?? "";
        $searchFields = $options['search_fields'] ?? ["title", "description"];
        $tableAlias = isset($options['table_alias']) ? $options['table_alias'] : substr($this->table, 0, 1);

        // Calculate offset
        $offset = ($page - 1) * $limit;

        // Validate direction
        $validDirection = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        // Format columns if it's an array
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        // Build base query
        $sql = "SELECT {$columns} FROM {$this->table} {$tableAlias}";

        // Simplified count SQL (if no GROUP BY is used)
        $countSql = empty($groupBy)
            ? "SELECT COUNT(*) as total FROM {$this->table} {$tableAlias}"
            : "SELECT COUNT(*) as total FROM (SELECT {$tableAlias}.id FROM {$this->table} {$tableAlias}";

        // Add joins
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $sql .= " " . $join;
                $countSql .= empty($groupBy) ? " " . $join : " " . $join;
            }
        }

        // Start WHERE clause
        $sql .= " WHERE 1=1";
        $countSql .= " WHERE 1=1";

        // Parameters for both queries
        $params = [];
        $countParams = [];

        // Add filter conditions
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $paramName = ':' . str_replace('.', '_', $key);
                $sql .= " AND {$key} = {$paramName}";
                $countSql .= " AND {$key} = {$paramName}";
                $params[$paramName] = $value;
                $countParams[$paramName] = $value;
            }
        }

        // Add search conditions if search term is provided
        if (!empty($searchTerm)) {
            $searchClauses = [];
            foreach ($searchFields as $field) {
                $fieldPath = strpos($field, '.') === false ? "{$tableAlias}.{$field}" : $field;
                $searchClauses[] = "{$fieldPath} LIKE :search_term";
            }

            if (!empty($searchClauses)) {
                $searchSql = " AND (" . implode(' OR ', $searchClauses) . ")";
                $sql .= $searchSql;
                $countSql .= $searchSql;
                $params[':search_term'] = $searchTerm;
                $countParams[':search_term'] = $searchTerm;
            }
        }

        // Add additional raw WHERE conditions
        if (!empty($additionalWhere)) {
            $sql .= " " . $additionalWhere;
            $countSql .= " " . $additionalWhere;
        }

        // Add GROUP BY if specified
        if (!empty($groupBy)) {
            $sql .= " GROUP BY " . $groupBy;
            $countSql .= " GROUP BY " . $groupBy . ") as count_table";
        }

        // Add ORDER BY
        if (!empty($sort)) {
            $sql .= " ORDER BY {$sort} {$validDirection}";
        }

        // Add LIMIT and OFFSET
        $sql .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        // Execute count query first
        $countStmt = $this->db->prepare($countSql);

        foreach ($countParams as $key => $value) {
            $paramType = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $countStmt->bindValue($key, $value, $paramType);
        }

        $countStmt->execute();
        $total = empty($groupBy)
            ? (int)$countStmt->fetchColumn()
            : (int)$countStmt->rowCount();

        // Execute main query to get data
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $paramType);
        }

        $stmt->execute();
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Calculate pagination metadata
        $totalPages = ceil($total / $limit);
        $hasNextPage = $page < $totalPages;
        $hasPrevPage = $page > 1;

        // Calculate from and to values for displaying "Showing X to Y of Z results"
        $from = $total > 0 ? ($page - 1) * $limit + 1 : 0;
        $to = min($page * $limit, $total);

        return [
            'items' => $items,
            'pagination' => [
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'has_next_page' => $hasNextPage,
                'has_prev_page' => $hasPrevPage,
                'from' => $from,
                'to' => $to
            ]
        ];
    }




    public function getTitle($id, $title, $tb)
    {
        $sql = "SELECT {$id},{$title} FROM {$tb}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy một bản ghi theo ID
     * 
     * @param int $id ID bản ghi
     * @return array|false Thông tin bản ghi hoặc false nếu không tìm thấy
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật bản ghi
     * 
     * @param int $id ID bản ghi
     * @param array $data Dữ liệu cập nhật
     * @return bool Kết quả cập nhật
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET ";
        $updateClauses = [];

        foreach ($data as $key => $value) {
            $updateClauses[] = "$key = :$key";
        }

        $sql .= implode(', ', $updateClauses);
        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    /**
     * Xóa bản ghi
     * 
     * @param int $id ID bản ghi
     * @return bool Kết quả xóa
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Đếm số bản ghi
     * 
     * @param array $conditions Điều kiện lọc
     * @param array $params Tham số cho câu truy vấn
     * @return int Số bản ghi
     */
    public function count($conditions = [], $params = [])
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";

        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        $stmt = $this->db->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Lấy danh sách bản ghi có phân trang
     * 
     * @param int $offset Vị trí bắt đầu
     * @param int $limit Số bản ghi cần lấy
     * @param string $orderBy Sắp xếp theo trường nào
     * @param string $orderDir Hướng sắp xếp (ASC hoặc DESC)
     * @param string $conditions Điều kiện WHERE (không bao gồm từ khóa WHERE)
     * @param array $params Tham số cho câu truy vấn
     * @return array Danh sách bản ghi
     */
    public function paginate($offset = 0, $limit = 10, $orderBy = 'id', $orderDir = 'DESC', $conditions = '', $params = [])
    {
        $sql = "SELECT * FROM {$this->table}";

        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        $sql .= " ORDER BY $orderBy $orderDir LIMIT :offset, :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Tạo bản ghi mới
     * 
     * @param array $data Dữ liệu của bản ghi mới
     * @return int|bool ID của bản ghi mới hoặc false nếu thất bại
     */
    public function create($data)
    {
        // Tạo câu lệnh SQL
        $columns = array_keys($data);
        $placeholders = array_map(function ($item) {
            return ":$item";
        }, $columns);

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") 
            VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);

        // Bind các giá trị
        foreach ($data as $key => $value) {
            $paramType = null;
            if (is_int($value)) {
                $paramType = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $paramType = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $paramType = PDO::PARAM_NULL;
            } else {
                $paramType = PDO::PARAM_STR;
            }

            $stmt->bindValue(":$key", $value, $paramType);
        }

        // Thực thi và trả về kết quả
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
}
