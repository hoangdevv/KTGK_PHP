<?php
class BaseController {
    protected $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    protected function getRegisteredCount() {
        if (isset($_SESSION['maSV'])) {
            require_once 'models/HocPhanModel.php';
            $hocPhanModel = new HocPhanModel($this->db);
            return $hocPhanModel->getRegisteredCoursesCount($_SESSION['maSV']);
        }
        return 0;
    }
    
    protected function render($view, $data = []) {
        // Add registered count to all views
        $data['registeredCount'] = $this->getRegisteredCount();
        
        // Extract data to make variables available in view
        extract($data);
        
        // Include the view file
        require_once "views/{$view}.php";
    }
}