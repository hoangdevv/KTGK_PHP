<?php require_once 'views/shared/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Chi tiết sinh viên</h2>
    
    <?php if ($sinhVien): ?>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?php echo htmlspecialchars($sinhVien['MaSV']); ?> - <?php echo htmlspecialchars($sinhVien['HoTen']); ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?php 
                    $imagePath = $sinhVien['Hinh'];
                    // Check if image exists and fix path
                    if (empty($imagePath)) {
                        $imagePath = '/websinhvien/Content/images/default.jpg';
                    } else if (strpos($imagePath, '/websinhvien') !== 0) {
                        $imagePath = '/websinhvien' . $imagePath;
                    }
                    ?>
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                         alt="<?php echo htmlspecialchars($sinhVien['HoTen']); ?>" 
                         class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Mã sinh viên</th>
                            <td><?php echo htmlspecialchars($sinhVien['MaSV']); ?></td>
                        </tr>
                        <tr>
                            <th>Họ tên</th>
                            <td><?php echo htmlspecialchars($sinhVien['HoTen']); ?></td>
                        </tr>
                        <tr>
                            <th>Giới tính</th>
                            <td><?php echo htmlspecialchars($sinhVien['GioiTinh']); ?></td>
                        </tr>
                        <tr>
                            <th>Ngày sinh</th>
                            <td><?php echo date('d/m/Y', strtotime($sinhVien['NgaySinh'])); ?></td>
                        </tr>
                        <tr>
                            <th>Ngành học</th>
                            <td><?php echo htmlspecialchars($sinhVien['TenNganh']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="index.php?controller=sinhvien&action=edit&maSV=<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" 
               class="btn btn-primary">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <a href="index.php?controller=sinhvien&action=delete&maSV=<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" 
               class="btn btn-danger"
               onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">
                <i class="fas fa-trash"></i> Xóa
            </a>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> Không tìm thấy thông tin sinh viên
    </div>
    <?php endif; ?>
</div>

<?php require_once 'views/shared/footer.php'; ?>