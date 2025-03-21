<?php
require_once 'models/AuthModel.php';

class AuthController {
    private $authModel;
    
    public function __construct($db) {
        $this->authModel = new AuthModel($db);
    }
    
    public function loginForm() {
        require_once 'views/auth/login.php';
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maSV = $_POST['maSV'];
            $password = $_POST['password'];
            
            // Verify if password matches MSSV
            if ($maSV === $password) {
                $sinhVien = $this->authModel->login($maSV);
                
                if ($sinhVien) {
                    $_SESSION['maSV'] = $sinhVien['MaSV'];
                    $_SESSION['hoTen'] = $sinhVien['HoTen'];
                    header('Location: index.php?controller=hocphan&action=index');
                    exit();
                }
            }
            
            $_SESSION['error'] = 'Mã số sinh viên hoặc mật khẩu không đúng';
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
    }
    
    public function logout() {
        // Xóa tất cả các session variables
        session_unset();
        
        // Hủy session
        session_destroy();
        
        // Chuyển hướng về trang đăng nhập
        header('Location: index.php?controller=auth&action=login');
        exit();
    }
}
?>