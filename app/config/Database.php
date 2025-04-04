<?php

namespace App\Config;

class Database
{
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        // Get environment variables with fallbacks
        $this->host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
        $this->port = $_ENV['DB_PORT'] ?? getenv('DB_PORT');
        $this->db_name = $_ENV['DB_NAME'] ?? getenv('DB_NAME');
        $this->username = $_ENV['DB_USER'] ?? getenv('DB_USER');
        $this->password = $_ENV['DB_PASS'] ?? getenv('DB_PASS');
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";

            // Options for TiDB Cloud
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                \PDO::MYSQL_ATTR_SSL_CA => false,
            ];

            $this->conn = new \PDO($dsn, $this->username, $this->password, $options);
            $this->conn->exec("set names utf8mb4");
        } catch (\PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new \Exception("Database connection failed. Please check the configuration.");
        }

        return $this->conn;
    }
}
