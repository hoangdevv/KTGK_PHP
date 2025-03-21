<?php
class DangKyModel {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getRegisteredCourses($maSV) {
        $query = "SELECT hp.*, dk.NgayDK, dk.MaDK 
                 FROM HocPhan hp 
                 INNER JOIN ChiTietDangKy ct ON hp.MaHP = ct.MaHP 
                 INNER JOIN DangKy dk ON ct.MaDK = dk.MaDK 
                 WHERE dk.MaSV = ?
                 ORDER BY dk.NgayDK DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalCredits($maSV) {
        $query = "SELECT SUM(hp.SoTinChi) 
                 FROM HocPhan hp 
                 INNER JOIN ChiTietDangKy ct ON hp.MaHP = ct.MaHP 
                 INNER JOIN DangKy dk ON ct.MaDK = dk.MaDK 
                 WHERE dk.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }
    
    public function saveRegistration($maSV) {
        try {
            $this->conn->beginTransaction();
            
            // Create DangKy record
            $query1 = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (CURDATE(), ?)";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(1, $maSV);
            $stmt1->execute();
            
            $maDK = $this->conn->lastInsertId();
            
            // Move temp registrations to ChiTietDangKy
            $query2 = "INSERT INTO ChiTietDangKy (MaDK, MaHP)
                      SELECT ?, MaHP FROM temp_dangky WHERE MaSV = ?";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(1, $maDK);
            $stmt2->bindParam(2, $maSV);
            $stmt2->execute();
            
            // Clear temp registrations
            $query3 = "DELETE FROM temp_dangky WHERE MaSV = ?";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(1, $maSV);
            $stmt3->execute();
            
            $this->conn->commit();
            return true;
        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    
    public function deleteTempRegistration($maSV, $maHP) {
        $query = "DELETE FROM temp_dangky WHERE MaSV = ? AND MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->bindParam(2, $maHP);
        return $stmt->execute();
    }
    
    public function deleteDangKy($maDK) {
        try {
            $this->conn->beginTransaction();
            
            // Delete from ChiTietDangKy first
            $query1 = "DELETE FROM ChiTietDangKy WHERE MaDK = ?";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(1, $maDK);
            $stmt1->execute();
            
            // Then delete from DangKy
            $query2 = "DELETE FROM DangKy WHERE MaDK = ?";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(1, $maDK);
            $stmt2->execute();
            
            $this->conn->commit();
            return true;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    
    public function getStudentInfo($maSV) {
        $query = "SELECT sv.*, nh.TenNganh 
                 FROM SinhVien sv
                 INNER JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                 WHERE sv.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}