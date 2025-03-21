<?php
class HocPhanModel {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all hoc phan
    public function getAllHocPhan() {
        // Thêm kiểm tra học phần đã đăng ký
        if(isset($_SESSION['maSV'])) {
            $query = "SELECT hp.*, 
                     CASE WHEN dk.MaDK IS NOT NULL THEN 1 ELSE 0 END as isRegistered
                     FROM HocPhan hp
                     LEFT JOIN ChiTietDangKy ct ON hp.MaHP = ct.MaHP
                     LEFT JOIN DangKy dk ON ct.MaDK = dk.MaDK AND dk.MaSV = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $_SESSION['maSV']);
        } else {
            $query = "SELECT * FROM HocPhan";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        return $stmt;
    }
    
    // Check if student already registered for this course
    public function isRegistered($maSV, $maHP) {
        $query = "SELECT COUNT(*) FROM DangKy dk 
                 INNER JOIN ChiTietDangKy ct ON dk.MaDK = ct.MaDK 
                 WHERE dk.MaSV = ? AND ct.MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->bindParam(2, $maHP);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    // Create DangKy and ChiTietDangKy records
    public function createDangKy($maSV, $maHP) {
        try {
            $this->conn->beginTransaction();
            
            // Kiểm tra đã đăng ký chưa
            if($this->isRegistered($maSV, $maHP)) {
                $this->conn->rollBack();
                return false;
            }
            
            // Tạo DangKy record
            $query1 = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (CURDATE(), ?)";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(1, $maSV);
            $stmt1->execute();
            
            $maDK = $this->conn->lastInsertId();
            
            // Tạo ChiTietDangKy record
            $query2 = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(1, $maDK);
            $stmt2->bindParam(2, $maHP);
            $stmt2->execute();
            
            $this->conn->commit();
            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    // Get registered courses count
    public function getRegisteredCoursesCount($maSV) {
        $query = "SELECT COUNT(*) FROM DangKy dk 
                 INNER JOIN ChiTietDangKy ct ON dk.MaDK = ct.MaDK 
                 WHERE dk.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>