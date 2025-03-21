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
    $('.register-btn').click(function(e) {
        e.preventDefault();
        const btn = $(this);
        const maHP = btn.data('mahp');
        
        // Disable button and show loading state
        btn.prop('disabled', true)
           .html('<i class="fas fa-spinner fa-spin"></i> Đang đăng ký...');
        
        $.ajax({
            url: 'index.php?controller=hocphan&action=register',
            type: 'POST',
            data: { maHP: maHP },
            dataType: 'json'
        })
        .done(function(result) {
            if (result.success) {
                btn.removeClass('btn-primary')
                   .addClass('btn-success')
                   .html('<i class="fas fa-check-circle"></i> Đã đăng ký')
                   .prop('disabled', true);
                
                $('.registration-count').text(result.count);
                
                setTimeout(function() {
                    window.location.href = 'index.php?controller=dangky&action=index';
                }, 1000);
            } else {
                btn.prop('disabled', false)
                   .html('<i class="fas fa-plus-circle"></i> Đăng ký');
                alert(result.message);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
            btn.prop('disabled', false)
               .html('<i class="fas fa-plus-circle"></i> Đăng ký');
            alert('Có lỗi xảy ra khi đăng ký');
        });
    });
});
</script>

<?php require_once 'views/shared/footer.php'; ?>