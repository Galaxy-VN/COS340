<?php $title = 'Khôi phục mật khẩu • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Auth Pages -->
<style>
    .auth-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .progress-step-circle {
        width: 36px;
        height: 36px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .progress-step-circle.active {
        background: var(--brand-500);
        color: white;
        box-shadow: 0 0 12px rgba(59, 130, 246, 0.4);
        border: none;
    }
    .progress-step-circle.inactive {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-soft);
    }
</style>

<!-- Hero Header -->
<div class="auth-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-key text-primary"></i>
            <span>Khôi phục quyền truy cập</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Khôi Phục Mật Khẩu</h1>
        <p class="text-muted mb-0">Trả lời các câu hỏi bảo mật đã đăng ký để cài đặt mật khẩu mới.</p>
    </div>
    <a href="/phamgiahuy/account/login" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-arrow-left"></i> Quay lại đăng nhập
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="surface-card p-4">
            <!-- Progress Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4 position-relative px-3">
                <div class="position-absolute top-50 start-0 end-0 translate-middle-y bg-white bg-opacity-5" style="height: 2px; z-index: 0;"></div>
                <div class="position-absolute top-50 start-0 bg-primary" style="height: 2px; width: <?php echo ($step - 1) * 50; ?>%; transition: width 0.3s ease; z-index: 0;"></div>
                
                <div class="text-center position-relative" style="z-index: 1;">
                    <div class="progress-step-circle <?php echo $step >= 1 ? 'active' : 'inactive'; ?> mx-auto">1</div>
                    <div class="small mt-1.5 fw-semibold <?php echo $step >= 1 ? 'text-primary' : 'text-soft'; ?>">Tài khoản</div>
                </div>
                <div class="text-center position-relative" style="z-index: 1;">
                    <div class="progress-step-circle <?php echo $step >= 2 ? 'active' : 'inactive'; ?> mx-auto">2</div>
                    <div class="small mt-1.5 fw-semibold <?php echo $step >= 2 ? 'text-primary' : 'text-soft'; ?>">Xác thực</div>
                </div>
                <div class="text-center position-relative" style="z-index: 1;">
                    <div class="progress-step-circle <?php echo $step >= 3 ? 'active' : 'inactive'; ?> mx-auto">3</div>
                    <div class="small mt-1.5 fw-semibold <?php echo $step >= 3 ? 'text-primary' : 'text-soft'; ?>">Mật khẩu mới</div>
                </div>
            </div>

            <!-- Error Notice -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <i class="ph ph-warning-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- STEP 1 -->
            <?php if ($step === 1): ?>
                <form action="/phamgiahuy/account/verifyUsername" method="POST">
                    <div class="field-card mb-4">
                        <h5 class="fw-bold text-white mb-1">Bước 1: Nhập tên đăng nhập</h5>
                        <div class="text-muted small">Tên tài khoản bạn sử dụng để đăng nhập hệ thống.</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên tài khoản *</label>
                        <input type="text" name="username" class="form-control" required placeholder="Nhập tên tài khoản...">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/phamgiahuy/account/login" class="btn btn-glass px-4 py-2">Hủy</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 d-flex align-items-center gap-1">
                            Tiếp tục <i class="ph ph-arrow-right"></i>
                        </button>
                    </div>
                </form>

            <!-- STEP 2 -->
            <?php elseif ($step === 2): ?>
                <form action="/phamgiahuy/account/verifyQuestions" method="POST">
                    <div class="field-card mb-4">
                        <h5 class="fw-bold text-white mb-1">Bước 2: Câu hỏi của @<?php echo htmlspecialchars($username); ?></h5>
                        <div class="text-muted small">Cung cấp đúng 3 câu trả lời đã thiết lập trước đó.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Câu hỏi 1: Tên con vật cưng đầu tiên? *</label>
                        <input type="text" name="security_a1" class="form-control" required placeholder="Nhập câu trả lời...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Câu hỏi 2: Tên trường tiểu học? *</label>
                        <input type="text" name="security_a2" class="form-control" required placeholder="Nhập câu trả lời...">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Câu hỏi 3: Sở thích lớn nhất? *</label>
                        <input type="text" name="security_a3" class="form-control" required placeholder="Nhập câu trả lời...">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/phamgiahuy/account/forgotPassword?action=reset" class="btn btn-glass px-3"><i class="ph ph-arrow-left"></i> Làm lại</a>
                        <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-1">
                            Xác thực <i class="ph ph-check"></i>
                        </button>
                    </div>
                </form>

            <!-- STEP 3 -->
            <?php elseif ($step === 3): ?>
                <form action="/phamgiahuy/account/resetPassword" method="POST">
                    <div class="field-card mb-4">
                        <h5 class="fw-bold text-white mb-1">Bước 3: Đặt lại mật khẩu</h5>
                        <div class="text-muted small">Chọn mật khẩu bảo mật mới cho tài khoản @<?php echo htmlspecialchars($username); ?>.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Mật khẩu mới *</label>
                        <input type="password" name="new_password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Xác nhận mật khẩu *</label>
                        <input type="password" name="confirm_new_password" class="form-control" required placeholder="Nhập lại mật khẩu mới">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/phamgiahuy/account/forgotPassword?action=reset" class="btn btn-glass px-3"><i class="ph ph-arrow-left"></i> Làm lại</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2.5 rounded-3">Cài đặt mật khẩu</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
