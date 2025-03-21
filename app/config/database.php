<?php
class Database {
    private $host = "localhost";
    private $db_name = "test1";
    private $username = "root"; 
    private $password = ""; 
    private $conn;

    // Kết nối đến cơ sở dữ liệu
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Lỗi kết nối: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>