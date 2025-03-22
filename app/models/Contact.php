<?php

namespace App\Models;

use PDO;

class Contact extends BaseModel
{
    protected $table = 'contacts';

    public function createContact($data)
    {
        try {
            $sql = "INSERT INTO contacts (
                    name, 
                    email, 
                    phone, 
                    subject, 
                    message, 
                    ip_address, 
                    user_agent
                ) VALUES (
                    :name, 
                    :email, 
                    :phone, 
                    :subject, 
                    :message, 
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
}
