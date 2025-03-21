<?php require_once 'views/shared/header.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Xác nhận xóa sinh viên</h4>
        </div>
        <div class="card-body">
            <?php if ($sinhVien): ?>
                <div class="alert alert-warning">
                    <h5>Bạn có chắc chắn muốn xóa sinh viên này?</h5>
                    <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($sinhVien['MaSV']); ?></p>
                    <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($sinhVien['HoTen']); ?></p>
                    <p><strong>Ngành học:</strong> <?php echo htmlspecialchars($sinhVien['TenNganh']); ?></p>
                </div>
                
                <form action="index.php?controller=sinhvien&action=destroy" method="POST">
                    <input type="hidden" name="maSV" value="<?php echo htmlspecialchars($sinhVien['MaSV']); ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Xác nhận xóa
                    </button>
                    <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </form>
            <?php else: ?>
                <div class="alert alert-danger">
                    Không tìm thấy thông tin sinh viên
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'views/shared/footer.php'; ?>