<?php
require_once 'models/DangKyModel.php';
require_once 'models/HocPhanModel.php';

class DangKyController
{
    private $dangKyModel;
    private $hocPhanModel;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->dangKyModel = new DangKyModel($db);
        $this->hocPhanModel = new HocPhanModel($db);
    }
    public function index()
    {
        if (!isset($_SESSION['maSV'])) {
            header('Location: index.php?controller=auth&action=loginForm');
            exit();
        }

        $registeredCourses = $this->dangKyModel->getRegisteredCourses($_SESSION['maSV']);
        $totalCredits = $this->dangKyModel->getTotalCredits($_SESSION['maSV']);
        $registeredCount = $this->hocPhanModel->getRegisteredCoursesCount($_SESSION['maSV']);

        require_once 'views/dangky/index.php';
    }

    public function confirm()
    {
        if (!isset($_SESSION['maSV'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $studentInfo = $this->dangKyModel->getStudentInfo($_SESSION['maSV']);
        $registeredCourses = $this->dangKyModel->getRegisteredCourses($_SESSION['maSV']);
        $totalCredits = $this->dangKyModel->getTotalCredits($_SESSION['maSV']);
        $registeredCount = $this->hocPhanModel->getRegisteredCoursesCount($_SESSION['maSV']);

        require_once 'views/dangky/confirm.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maSV = $_SESSION['maSV'];

            if ($this->dangKyModel->saveRegistration($maSV)) {
                $_SESSION['message'] = 'Đăng ký học phần thành công';
                header('Location: index.php?controller=dangky&action=index');
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi lưu đăng ký';
                header('Location: index.php?controller=dangky&action=confirm');
            }
            exit();
        }
    }

    public function delete()
    {
        if (!isset($_SESSION['maSV'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['maDK'])) {
            $maDK = $_POST['maDK'];
            $result = $this->dangKyModel->deleteDangKy($maDK);

            if ($result) {
                $count = $this->hocPhanModel->getRegisteredCoursesCount($_SESSION['maSV']);
                echo json_encode([
                    'success' => true,
                    'count' => $count
                ]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
}
