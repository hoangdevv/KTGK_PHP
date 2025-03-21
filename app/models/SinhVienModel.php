<?php
class SinhVienModel {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all sinh vien
    public function getAllSinhVien() {
        $query = "SELECT sv.*, ng.TenNganh 
                  FROM SinhVien sv 
                  LEFT JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Get single sinh vien
    public function getSinhVienById($maSV) {
        $query = "SELECT sv.*, ng.TenNganh 
                  FROM SinhVien sv 
                  LEFT JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh 
                  WHERE sv.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->execute();
        return $stmt;
    }
    
    // Create sinh vien
    public function createSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh) {
        $query = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->bindParam(2, $hoTen);
        $stmt->bindParam(3, $gioiTinh);
        $stmt->bindParam(4, $ngaySinh);
        $stmt->bindParam(5, $hinh);
        $stmt->bindParam(6, $maNganh);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Update sinh vien
    public function updateSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh) {
        $query = "UPDATE SinhVien 
                  SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? 
                  WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $hoTen);
        $stmt->bindParam(2, $gioiTinh);
        $stmt->bindParam(3, $ngaySinh);
        $stmt->bindParam(4, $hinh);
        $stmt->bindParam(5, $maNganh);
        $stmt->bindParam(6, $maSV);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete sinh vien
    public function deleteSinhVien($maSV) {
        try {
            $query = "DELETE FROM SinhVien WHERE MaSV = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $maSV);
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Get all nganh hoc for dropdown
    public function getAllNganhHoc() {
        $query = "SELECT * FROM NganhHoc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>