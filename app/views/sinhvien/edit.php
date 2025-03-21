<?php require_once 'views/shared/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa sinh viên</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="index.php?controller=sinhvien&action=update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="maSV" value="<?php echo htmlspecialchars($sinhVien['MaSV']); ?>">
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mã sinh viên</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control-plaintext" value="<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Họ tên</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="hoTen" value="<?php echo htmlspecialchars($sinhVien['HoTen']); ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Giới tính</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gioiTinh" value="Nam" <?php echo ($sinhVien['GioiTinh'] == 'Nam') ? 'checked' : ''; ?>>
                            <label class="form-check-label">Nam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gioiTinh" value="Nữ" <?php echo ($sinhVien['GioiTinh'] == 'Nữ') ? 'checked' : ''; ?>>
                            <label class="form-check-label">Nữ</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ngày sinh</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="ngaySinh" value="<?php echo date('Y-m-d', strtotime($sinhVien['NgaySinh'])); ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ngành học</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="maNganh" required>
                            <?php foreach($nganhHocs as $nganh): ?>
                                <option value="<?php echo htmlspecialchars($nganh['MaNganh']); ?>" 
                                    <?php echo ($sinhVien['MaNganh'] == $nganh['MaNganh']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($nganh['TenNganh']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Hình ảnh</label>
                    <div class="col-sm-10">
                        <img src="<?php echo htmlspecialchars($sinhVien['Hinh']); ?>" class="img-thumbnail mb-2" style="max-height: 100px;">
                        <input type="file" class="form-control-file" name="hinh">
                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Hủy</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'views/shared/footer.php'; ?>