<?php
class AuthModel {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function login($maSV) {
        $query = "SELECT * FROM SinhVien WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
?>