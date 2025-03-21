<?php
session_start();
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/app');

// Include database configuration
require_once 'config/database.php';

// Create DB connection
$database = new Database();
$db = $database->getConnection();

// Get controller and action from URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route to appropriate controller
switch ($controller) {
    case 'sinhvien':
        require_once 'controllers/SinhVienController.php';
        $controller = new SinhVienController($db);

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'detail':
                if (!isset($_GET['maSV'])) {
                    header('Location: index.php?controller=sinhvien&action=index');
                    exit();
                }
                $controller->detail($_GET['maSV']); // Changed from MaSV to maSV
                break;
            case 'create':
                $controller->createForm();
                break;
            case 'store':
                $controller->create();
                break;
            case 'edit':
                $controller->editForm($_GET['maSV']);
                break;
            case 'update':
                $controller->edit();
                break;
            case 'delete':
                if (!isset($_GET['maSV'])) {
                    header('Location: index.php?controller=sinhvien&action=index');
                    exit();
                }
                $controller->deleteForm($_GET['maSV']);
                break;
            case 'destroy':
                $controller->delete();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'hocphan':
        require_once 'controllers/HocPhanController.php';
        $controller = new HocPhanController($db);

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'register':
                $controller->register();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'dangky':
        require_once 'controllers/DangKyController.php';
        $controller = new DangKyController($db);

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'confirm':
                $controller->confirm();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'auth':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController($db);

        switch ($action) {
            case 'login':
                $controller->loginForm();
                break;
            case 'authenticate':
                $controller->login();
                break;
            case 'logout':
                $controller->logout();
                break;
            default:
                $controller->loginForm();
                break;
        }
        break;

    default:
        if (!isset($_SESSION['maSV'])) {
            header('Location: index.php?controller=auth&action=login');
        } else {
            header('Location: index.php?controller=sinhvien&action=index');
        }
        exit();
}

// Handle database connection errors
if (!$db) {
    die("Không thể kết nối đến cơ sở dữ liệu.");
}
