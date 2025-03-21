<?php require_once 'views/shared/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Đăng ký học phần</h2>
        <div>
            <span class="badge badge-primary">Số học phần đã chọn: <?php echo count($registeredCourses); ?></span>
            <span class="badge badge-info ml-2">Tổng số tín chỉ: <?php echo $totalCredits; ?></span>
        </div>
    </div>

    <?php if (!empty($registeredCourses)): ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên học phần</th>
                    <th>Số tín chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registeredCourses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['MaHP']); ?></td>
                    <td><?php echo htmlspecialchars($course['TenHP']); ?></td>
                    <td><?php echo htmlspecialchars($course['SoTinChi']); ?></td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-mahp="<?php echo $course['MaHP']; ?>">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-center mt-3">
            <a href="index.php?controller=dangky&action=confirm" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu đăng ký
            </a>
            <a href="index.php?controller=hocphan&action=index" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Thêm học phần
            </a>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Bạn chưa đăng ký học phần nào.
            <a href="index.php?controller=hocphan&action=index" class="alert-link">Đăng ký ngay</a>
        </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    $('.delete-btn').click(function() {
        if (confirm('Bạn có chắc chắn muốn xóa học phần này?')) {
            const btn = $(this);
            const maHP = btn.data('mahp');
            
            $.ajax({
                url: 'index.php?controller=dangky&action=delete',
                type: 'POST',
                data: { maHP: maHP },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        btn.closest('tr').remove();
                        location.reload(); // Refresh to update counts
                    } else {
                        alert('Có lỗi xảy ra khi xóa');
                    }
                }
            });
        }
    });
});
</script>

<?php require_once 'views/shared/footer.php'; ?>