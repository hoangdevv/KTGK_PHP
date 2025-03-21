<?php
require_once 'models/SinhVienModel.php';

class SinhVienController
{
    private $sinhVienModel;

    public function __construct($db)
    {
        $this->sinhVienModel = new SinhVienModel($db);
    }

    // Display list of all sinh vien
    public function index()
    {
        $result = $this->sinhVienModel->getAllSinhVien();
        $sinhViens = $result->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/sinhvien/index.php';
    }

    // Display sinh vien details
    public function detail($maSV)
    {
        $result = $this->sinhVienModel->getSinhVienById($maSV);
        $sinhVien = $result->fetch(PDO::FETCH_ASSOC);
        require_once 'views/sinhvien/detail.php';
    }

    // Display create form
    public function createForm()
    {
        $nganhHocs = $this->sinhVienModel->getAllNganhHoc()->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/sinhvien/create.php';
    }

    // Process create form
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Handle file upload
                $hinh = '/websinhvien/Content/images/default.jpg'; 
                
                if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/websinhvien/Content/images/";
                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    
                    $fileExtension = strtolower(pathinfo($_FILES['hinh']['name'], PATHINFO_EXTENSION));
                    $fileName = time() . '_' . uniqid() . '.' . $fileExtension;
                    $target_file = $target_dir . $fileName;
                    
                    if (move_uploaded_file($_FILES['hinh']['tmp_name'], $target_file)) {
                        $hinh = '/Content/images/' . $fileName;
                    }
                }
                
                // Create sinh vien with image path
                $result = $this->sinhVienModel->createSinhVien(
                    $_POST['maSV'],
                    $_POST['hoTen'],
                    $_POST['gioiTinh'],
                    $_POST['ngaySinh'],
                    $hinh,
                    $_POST['maNganh']
                );
                
                if ($result) {
                    header('Location: index.php?controller=sinhvien&action=index');
                    exit();
                }
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    // Display edit form
    public function editForm($maSV)
    {
        $result = $this->sinhVienModel->getSinhVienById($maSV);
        $sinhVien = $result->fetch(PDO::FETCH_ASSOC);
        $nganhHocs = $this->sinhVienModel->getAllNganhHoc()->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/sinhvien/edit.php';
    }

    // Process edit form
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maSV = $_POST['maSV'];
            $currentSinhVien = $this->sinhVienModel->getSinhVienById($maSV)->fetch(PDO::FETCH_ASSOC);

            // Handle file upload if there is a file
            $hinh = $currentSinhVien['Hinh']; // Keep current image by default
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $target_dir = "Content/images/";
                $fileName = basename($_FILES["hinh"]["name"]);
                $target_file = $target_dir . $fileName;

                // Move uploaded file
                if (move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file)) {
                    $hinh = '/' . $target_file;
                }
            }

            // Update sinh vien
            if ($this->sinhVienModel->updateSinhVien(
                $maSV,
                $_POST['hoTen'],
                $_POST['gioiTinh'],
                $_POST['ngaySinh'],
                $hinh,
                $_POST['maNganh']
            )) {
                header('Location: index.php?controller=sinhvien&action=index');
            } else {
                echo "Error updating sinh vien";
            }
        }
    }

    // Display delete confirmation
    public function deleteForm($maSV)
    {
        $result = $this->sinhVienModel->getSinhVienById($maSV);
        $sinhVien = $result->fetch(PDO::FETCH_ASSOC);
        require_once 'views/sinhvien/delete.php';
    }

    // Process delete
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['maSV'])) {
            try {
                $maSV = $_POST['maSV'];
                if ($this->sinhVienModel->deleteSinhVien($maSV)) {
                    header('Location: index.php?controller=sinhvien&action=index');
                    exit();
                } else {
                    throw new Exception("Không thể xóa sinh viên");
                }
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }
}
?>