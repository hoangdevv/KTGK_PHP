<?php
require_once 'models/HocPhanModel.php';

class HocPhanController {
    private $hocPhanModel;
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
        $this->hocPhanModel = new HocPhanModel($db);
    }
    
    public function index() {
        if (!isset($_SESSION['maSV'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
        
        $result = $this->hocPhanModel->getAllHocPhan();
        $hocPhans = $result->fetchAll(PDO::FETCH_ASSOC);
        $registeredCount = $this->hocPhanModel->getRegisteredCoursesCount($_SESSION['maSV']);
        
        require_once 'views/hocphan/index.php';
    }
    
    public function register() {
        if (!isset($_SESSION['maSV'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['maHP'])) {
            $maHP = $_POST['maHP'];
            $maSV = $_SESSION['maSV'];
            
            if ($this->hocPhanModel->isRegistered($maSV, $maHP)) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Bạn đã đăng ký học phần này rồi'
                ]);
                return;
            }
            
            if ($this->hocPhanModel->createDangKy($maSV, $maHP)) {
                $count = $this->hocPhanModel->getRegisteredCoursesCount($maSV);
                echo json_encode([
                    'success' => true,
                    'message' => 'Đăng ký học phần thành công',
                    'count' => $count
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi đăng ký'
                ]);
            }
        }
    }
}
?>