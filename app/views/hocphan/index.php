<?php require_once 'views/shared/header.php'; ?>

<div class="container mt-4">
    <h2>Danh sách học phần</h2>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã HP</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hocPhans as $hp): ?>
            <tr>
                <td><?php echo htmlspecialchars($hp['MaHP']); ?></td>
                <td><?php echo htmlspecialchars($hp['TenHP']); ?></td>
                <td><?php echo htmlspecialchars($hp['SoTinChi']); ?></td>
                <td>
                    <?php if (!$hp['isRegistered']): ?>
                        <button class="btn btn-primary btn-sm register-btn" 
                                data-mahp="<?php echo htmlspecialchars($hp['MaHP']); ?>">
                            <i class="fas fa-plus-circle"></i> Đăng ký
                        </button>
                    <?php else: ?>
                        <button class="btn btn-success btn-sm" disabled>
                            <i class="fas fa-check-circle"></i> Đã đăng ký
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('.register-btn').click(function() {
        const btn = $(this);
        const maHP = btn.data('mahp');
        
        btn.prop('disabled', true)
           .html('<i class="fas fa-spinner fa-spin"></i> Đang đăng ký...');
        
        $.ajax({
            url: 'index.php?controller=hocphan&action=register',
            type: 'POST',
            data: { maHP: maHP },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    btn.removeClass('btn-primary')
                       .addClass('btn-success')
                       .html('<i class="fas fa-check-circle"></i> Đã đăng ký')
                       .prop('disabled', true);
                    
                    // Update header badge
                    $('.badge.badge-light').text(result.count);
                    
                    // Optional: Reload page after short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    btn.prop('disabled', false)
                       .html('<i class="fas fa-plus-circle"></i> Đăng ký');
                    alert(result.message);
                }
            },
            error: function() {
                btn.prop('disabled', false)
                   .html('<i class="fas fa-plus-circle"></i> Đăng ký');
                alert('Có lỗi xảy ra khi đăng ký');
            }
        });
    });
});
</script>

<?php require_once 'views/shared/footer.php'; ?>