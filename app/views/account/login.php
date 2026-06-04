<?php $title = 'Đăng nhập • COS340 Store'; ?>
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
                <i class="ph ph-lock-key-open text-primary" style="font-size: 2rem;"></i>
            </div>
            <h1 class="h3 fw-bold text-white mb-1">Đăng Nhập</h1>
            <p class="text-muted small">Chào mừng bạn quay lại với cửa hàng.</p>
        </div>

        <!-- Error Alert -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger border-0 rounded-3 mb-4 small">
                <i class="ph ph-warning-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="/phamgiahuy/account/checkLogin" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên tài khoản *</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required placeholder="Tên đăng nhập...">
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label text-muted small text-uppercase tracking-wider fw-semibold mb-0">Mật khẩu *</label>
                    <a href="/phamgiahuy/account/forgotPassword?action=reset" class="small text-primary text-decoration-none" style="font-size: 0.8rem;">Quên mật khẩu?</a>
                </div>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Nhập mật khẩu...">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                    <i class="ph ph-sign-in"></i> Đăng nhập
                </button>
                <a href="/phamgiahuy/account/register" class="btn btn-glass py-2.5 rounded-3 text-center">
                    Tạo tài khoản mới
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
