<?php $title = 'Đăng nhập'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-right-to-bracket"></i>
            <span>Welcome back</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Đăng nhập</h1>
        <p class="lead mb-0">Đăng nhập để quản lý tài khoản và theo dõi đơn hàng.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-5 col-xl-4">
        <div class="surface-card p-3 p-lg-4">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 rounded-4">
                    <i class="fas fa-circle-exclamation me-2"></i><?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form action="/phamgiahuy/account/checkLogin" method="POST">
                <div class="field-card mb-3">
                    <div class="fw-semibold mb-1">Thông tin đăng nhập</div>
                    <div class="muted-note">Nhập tài khoản và mật khẩu đã đăng ký.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên tài khoản *</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mật khẩu *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-right-to-bracket me-1"></i>Đăng nhập</button>
                    <a href="/phamgiahuy/account/register" class="btn btn-outline-secondary">Đăng ký</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
