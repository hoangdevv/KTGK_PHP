<?php require_once 'views/shared/header.php'; ?>

<div class="container mt-4">
    <h1>Thêm mới sinh viên</h1>
    
    <form action="index.php?controller=sinhvien&action=store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="maSV">Mã sinh viên</label>
            <input type="text" class="form-control" id="maSV" name="maSV" required>
        </div>
        
        <div class="form-group">
            <label for="hoTen">Họ tên</label>
            <input type="text" class="form-control" id="hoTen" name="hoTen" required>
        </div>
        
        <div class="form-group">
            <label>Giới tính</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gioiTinh" id="nam" value="Nam" checked>
                <label class="form-check-label" for="nam">Nam</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gioiTinh" id="nu" value="Nữ">
                <label class="form-check-label" for="nu">Nữ</label>
            </div>
        </div>
        
        <div class="form-group">
            <label for="ngaySinh">Ngày sinh</label>
            <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" required>
        </div>
        
        <div class="form-group">
            <label for="maNganh">Ngành học</label>
            <select class="form-control" id="maNganh" name="maNganh" required>
                <option value="">-- Chọn ngành học --</option>
                <?php foreach($nganhHocs as $nganh): ?>
                    <option value="<?php echo htmlspecialchars($nganh['MaNganh']); ?>">
                        <?php echo htmlspecialchars($nganh['TenNganh']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="hinh">Hình ảnh</label>
            <input type="file" class="form-control-file" id="hinh" name="hinh">
        </div>
        
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php require_once 'views/shared/footer.php'; ?>