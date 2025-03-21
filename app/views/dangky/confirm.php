<?php require_once 'views/shared/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Xác nhận đăng ký học phần</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Thông tin sinh viên</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>MSSV:</strong> <?php echo htmlspecialchars($studentInfo['MaSV']); ?></p>
                    <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($studentInfo['HoTen']); ?></p>
                    <p><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($studentInfo['NgaySinh'])); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngành học:</strong> <?php echo htmlspecialchars($studentInfo['TenNganh']); ?></p>
                    <p><strong>Ngày đăng ký:</strong> <?php echo date('d/m/Y'); ?></p>
                    <p><strong>Tổng số tín chỉ:</strong> <?php echo $totalCredits; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Danh sách học phần đăng ký</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Mã HP</th>
                        <th>Tên học phần</th>
                        <th>Số tín chỉ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registeredCourses as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['MaHP']); ?></td>
                        <td><?php echo htmlspecialchars($course['TenHP']); ?></td>
                        <td><?php echo htmlspecialchars($course['SoTinChi']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <form action="index.php?controller=dangky&action=save" method="POST" class="d-inline">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check"></i> Xác nhận đăng ký
            </button>
        </form>
        <a href="index.php?controller=dangky&action=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<?php require_once 'views/shared/footer.php'; ?>