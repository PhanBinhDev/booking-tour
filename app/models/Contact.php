<?php

namespace App\Models;

use PDO;

class Contact extends BaseModel
{
    protected $table = 'contacts';

    public function __construct()
    {
        parent::__construct();
        $this->table = 'contacts'; // Set the table name
    }

    public function createContact($data)
    {
        try {
            $sql = "INSERT INTO contacts (
                    name, 
                    email, 
                    phone, 
                    subject, 
                    message, 
                    status,
                    ip_address, 
                    user_agent
                ) VALUES (
                    :name, 
                    :email, 
                    :phone, 
                    :subject,
                    :message, 
                    :status,
                    :ip_address, 
                    :user_agent
                )";



            $stmt = $this->db->prepare($sql);

            // Bind parameters
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':phone', $data['phone'] ?? null);
            $stmt->bindValue(':subject', $data['subject'] ?? null);
            $stmt->bindValue(':message', $data['message']);
            $stmt->bindValue(':status', 'new');
            $stmt->bindValue(':ip_address', $_SERVER['REMOTE_ADDR'] ?? null);
            $stmt->bindValue(':user_agent', $_SERVER['HTTP_USER_AGENT'] ?? null);

            $result = $stmt->execute();

            if ($result) {
                return $this->db->lastInsertId();
            } else {
                error_log("Failed to create contact: " . print_r($stmt->errorInfo(), true));
                return false;
            }
        } catch (\Exception $e) {
            error_log("Error creating contact: " . $e->getMessage());
            return false;
        }
    }
    public function getContacts($limit = null, $offset = 0, $status = null)
    {
        try {
            // Xây dựng câu truy vấn SQL cơ bản
            $sql = "SELECT * FROM contacts";

            // Thêm điều kiện lọc theo trạng thái nếu được chỉ định
            if ($status !== null) {
                $sql .= " WHERE status = :status";
            }

            // Sắp xếp kết quả theo thời gian tạo mới nhất trước
            $sql .= " ORDER BY created_at DESC";

            // Thêm giới hạn số lượng bản ghi nếu được chỉ định
            if ($limit !== null) {
                $sql .= " LIMIT :offset, :limit";
            }

            // Chuẩn bị câu truy vấn
            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho các tham số
            if ($status !== null) {
                $stmt->bindValue(':status', $status);
            }

            if ($limit !== null) {
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }

            // Thực thi truy vấn
            $stmt->execute();

            // Trả về kết quả dưới dạng mảng
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // Ghi log lỗi
            error_log("Lỗi khi lấy dữ liệu liên hệ: " . $e->getMessage());
            return false;
        }
    }

    public function getContactById($id)
    {
        try {
            // Chuẩn bị câu truy vấn SQL
            $sql = "SELECT * FROM contacts WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho tham số ID
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            // Thực thi truy vấn
            $stmt->execute();

            // Kiểm tra xem có dữ liệu trả về không
            if ($stmt->rowCount() === 0) {
                return null; // Không tìm thấy liên hệ với ID này
            }

            // Trả về dữ liệu liên hệ dưới dạng mảng kết hợp
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // Ghi log lỗi
            error_log("Lỗi khi lấy thông tin liên hệ: " . $e->getMessage());
            return false;
        }
    }

    public function archive($id)
    {
        try {
            // Chuẩn bị câu truy vấn SQL để cập nhật trạng thái
            $sql = "UPDATE contacts SET status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho các tham số
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':status', 'archived');

            // Thực thi truy vấn
            $result = $stmt->execute();

            // Kiểm tra kết quả và trả về
            if ($result && $stmt->rowCount() > 0) {
                return true; // Cập nhật thành công
            } else {
                // Ghi log nếu không có hàng nào được cập nhật
                if ($stmt->rowCount() === 0) {
                    error_log("Không tìm thấy liên hệ với ID: $id để lưu trữ");
                } else {
                    error_log("Lỗi khi lưu trữ liên hệ: " . print_r($stmt->errorInfo(), true));
                }
                return false;
            }
        } catch (\Exception $e) {
            // Ghi log lỗi
            error_log("Lỗi khi lưu trữ liên hệ: " . $e->getMessage());
            return false;
        }
    }

    public function markRead($id)
    {
        try {
            // Chuẩn bị câu truy vấn SQL để cập nhật trạng thái
            $sql = "UPDATE contacts SET status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho các tham số
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':status', 'read');

            // Thực thi truy vấn
            $result = $stmt->execute();

            // Kiểm tra kết quả và trả về
            if ($result && $stmt->rowCount() > 0) {
                return true; // Cập nhật thành công
            } else {
                // Ghi log nếu không có hàng nào được cập nhật
                if ($stmt->rowCount() === 0) {
                    error_log("Không tìm thấy liên hệ với ID: $id để đánh dấu đã đọc");
                } else {
                    error_log("Lỗi khi đánh dấu đã đọc liên hệ: " . print_r($stmt->errorInfo(), true));
                }
                return false;
            }
        } catch (\Exception $e) {
            // Ghi log lỗi
            error_log("Lỗi khi đánh dấu đã đọc liên hệ: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates the status of a contact
     * 
     * @param int $id ID của liên hệ cần cập nhật
     * @param string $status Trạng thái mới ('new', 'read', 'replied', 'archived')
     * @return bool Trả về true nếu thành công, false nếu thất bại
     */
    public function updateStatus($id, $status)
    {
        try {
            // Kiểm tra trạng thái hợp lệ
            $validStatuses = ['new', 'read', 'replied', 'archived'];
            if (!in_array($status, $validStatuses)) {
                error_log("Trạng thái không hợp lệ: $status");
                return false;
            }

            // Chuẩn bị câu truy vấn SQL để cập nhật trạng thái
            $sql = "UPDATE contacts SET status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho các tham số
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':status', $status);

            // Thực thi truy vấn
            $result = $stmt->execute();

            // Kiểm tra kết quả và trả về
            if ($result && $stmt->rowCount() > 0) {
                return true; // Cập nhật thành công
            } else {
                // Ghi log nếu không có hàng nào được cập nhật
                if ($stmt->rowCount() === 0) {
                    error_log("Không tìm thấy liên hệ với ID: $id để cập nhật trạng thái");
                } else {
                    error_log("Lỗi khi cập nhật trạng thái liên hệ: " . print_r($stmt->errorInfo(), true));
                }
                return false;
            }
        } catch (\Exception $e) {
            // Ghi log lỗi
            error_log("Lỗi khi cập nhật trạng thái liên hệ: " . $e->getMessage());
            return false;
        }
    }
}