<?php $title = 'Đăng ký tài khoản • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Auth Pages -->
<style>
    .auth-card-wrapper {
        min-height: calc(75vh - 72px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    .auth-card {
        background: var(--paper);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-float), var(--liquid-highlight);
        padding: 2.5rem;
        width: 100%;
        max-width: 440px;
        backdrop-filter: var(--glass-blur);
        position: relative;
        overflow: hidden;
    }
    .auth-card::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.2), transparent 70%);
        pointer-events: none;
    }
</style>

<div class="auth-card-wrapper">
    <div class="auth-card">
        <!-- Logo / Title -->
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 mb-3" style="width: 64px; height: 64px; border: 1px solid rgba(59, 130, 246, 0.2);">
                <i class="ph ph-user-plus text-primary" style="font-size: 2rem;"></i>
            </div>
            <h1 class="h3 fw-bold text-white mb-1">Đăng Ký</h1>
            <p class="text-muted small">Tạo tài khoản mới để đặt hàng và tích lũy ưu đãi.</p>
        </div>

        <!-- Errors Alert -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger border-0 rounded-3 mb-4 small">
                <div class="fw-bold mb-1"><i class="ph ph-warning-circle"></i> Vui lòng sửa các lỗi sau:</div>
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="/phamgiahuy/account/save" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên tài khoản *</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required placeholder="Nhập tên đăng nhập...">
            </div>

            <div class="mb-3">
                <label for="fullname" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Họ và tên *</label>
                <input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>" required placeholder="Nguyễn Văn A">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Mật khẩu *</label>
                <input type="password" name="password" id="password" class="form-control" minlength="6" required placeholder="Tối thiểu 6 ký tự">
            </div>

            <div class="mb-4">
                <label for="confirmpassword" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Xác nhận mật khẩu *</label>
                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" minlength="6" required placeholder="Nhập lại mật khẩu...">
            </div>
            
            <input type="hidden" name="role" value="user">

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                    <i class="ph ph-user-plus"></i> Đăng ký ngay
                </button>
                <a href="/phamgiahuy/account/login" class="btn btn-glass py-2.5 rounded-3 text-center">
                    Đăng nhập bằng tài khoản cũ
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
