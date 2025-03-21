<!DOCTYPE html>
<html>

<head>
    <title>Danh sách sinh viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php
    $pageTitle = "Danh sách Sinh viên";
    require_once 'views/shared/header.php';
    ?>
    <div class="container mt-4"></div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Danh sách sinh viên</h2>
            <a href="index.php?controller=sinhvien&action=create" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Mã SV</th>
                    <th>Họ tên</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Ngành học</th>
                    <th>Hình</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sinhViens as $sinhVien): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sinhVien['MaSV']); ?></td>
                        <td><?php echo htmlspecialchars($sinhVien['HoTen']); ?></td>
                        <td><?php echo htmlspecialchars($sinhVien['GioiTinh']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($sinhVien['NgaySinh'])); ?></td>
                        <td><?php echo htmlspecialchars($sinhVien['TenNganh']); ?></td>
                        <td>
                            <?php 
                            $imagePath = empty($sinhVien['Hinh']) ? 
                                '/websinhvien/Content/images/default.jpg' : 
                                '/websinhvien' . $sinhVien['Hinh'];
                            ?>
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                 alt="Ảnh <?php echo htmlspecialchars($sinhVien['HoTen']); ?>" 
                                 class="img-thumbnail"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="index.php?controller=sinhvien&action=detail&maSV=<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" 
                                   class="btn btn-info btn-sm" title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?controller=sinhvien&action=edit&maSV=<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" 
                                   class="btn btn-primary btn-sm" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?controller=sinhvien&action=delete&maSV=<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');" 
                                   title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require_once 'views/shared/footer.php'; ?>
</body>

</html>