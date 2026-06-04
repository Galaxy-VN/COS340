<?php $title = 'Khôi phục mật khẩu'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-key"></i>
            <span>Khôi phục tài khoản</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Khôi phục mật khẩu</h1>
        <p class="lead mb-0">Trả lời đúng 3 câu hỏi bảo mật để đặt lại mật khẩu mới cho tài khoản.</p>
    </div>
    <a href="/phamgiahuy/account/login" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index: 1;">
        <i class="fas fa-arrow-left me-2"></i>Quay lại đăng nhập
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="surface-card p-3 p-lg-4">
            <!-- Progress indicator -->
            <div class="d-flex justify-content-between align-items-center mb-4 position-relative px-2">
                <div class="position-absolute top-50 start-0 end-0 translate-middle-y bg-secondary bg-opacity-25" style="height: 2px; z-index: 0;"></div>
                <div class="position-absolute top-50 start-0 bg-primary" style="height: 2px; width: <?php echo ($step - 1) * 50; ?>%; transition: width 0.3s; z-index: 0;"></div>
                
                <div class="text-center position-relative" style="z-index: 1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center <?php echo $step >= 1 ? 'bg-primary text-white' : 'bg-dark text-soft border'; ?> fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">1</div>
                    <div class="small mt-1 fw-semibold <?php echo $step >= 1 ? 'text-primary' : 'text-soft'; ?>">Tài khoản</div>
                </div>
                <div class="text-center position-relative" style="z-index: 1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center <?php echo $step >= 2 ? 'bg-primary text-white' : 'bg-dark text-soft border'; ?> fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">2</div>
                    <div class="small mt-1 fw-semibold <?php echo $step >= 2 ? 'text-primary' : 'text-soft'; ?>">Xác thực</div>
                </div>
                <div class="text-center position-relative" style="z-index: 1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center <?php echo $step >= 3 ? 'bg-primary text-white' : 'bg-dark text-soft border'; ?> fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">3</div>
                    <div class="small mt-1 fw-semibold <?php echo $step >= 3 ? 'text-primary' : 'text-soft'; ?>">Mật khẩu mới</div>
                </div>
            </div>

            <!-- Error Notification -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 rounded-4 mb-3">
                    <i class="fas fa-circle-exclamation me-2"></i><?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- STEP 1: Enter Username -->
            <?php if ($step === 1): ?>
                <form action="/phamgiahuy/account/verifyUsername" method="POST">
                    <div class="field-card mb-3">
                        <div class="fw-semibold mb-1">Bước 1: Nhập tên tài khoản</div>
                        <div class="muted-note">Nhập tên tài khoản của bạn để hệ thống tìm câu hỏi bảo mật tương ứng.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên tài khoản *</label>
                        <input type="text" name="username" class="form-control" required placeholder="Nhập tên tài khoản của bạn">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/phamgiahuy/account/login" class="btn btn-outline-secondary">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary">Tiếp tục <i class="fas fa-arrow-right ms-1"></i></button>
                    </div>
                </form>

            <!-- STEP 2: Answer security questions -->
            <?php elseif ($step === 2): ?>
                <form action="/phamgiahuy/account/verifyQuestions" method="POST">
                    <div class="field-card mb-3">
                        <div class="fw-semibold mb-1">Bước 2: Câu hỏi xác thực của @<?php echo htmlspecialchars($username); ?></div>
                        <div class="muted-note">Hãy trả lời đúng cả 3 câu hỏi bảo mật dưới đây để xác nhận quyền sở hữu tài khoản.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Câu hỏi 1: Tên con vật cưng đầu tiên của bạn là gì? *</label>
                        <input type="text" name="security_a1" class="form-control" required placeholder="Nhập câu trả lời">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Câu hỏi 2: Tên trường tiểu học của bạn là gì? *</label>
                        <input type="text" name="security_a2" class="form-control" required placeholder="Nhập câu trả lời">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Câu hỏi 3: Sở thích lớn nhất của bạn là gì? *</label>
                        <input type="text" name="security_a3" class="form-control" required placeholder="Nhập câu trả lời">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/phamgiahuy/account/forgotPassword?action=reset" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Bắt đầu lại</a>
                        <button type="submit" class="btn btn-primary">Xác minh <i class="fas fa-check ms-1"></i></button>
                    </div>
                </form>

            <!-- STEP 3: Enter new password -->
            <?php elseif ($step === 3): ?>
                <form action="/phamgiahuy/account/resetPassword" method="POST">
                    <div class="field-card mb-3">
                        <div class="fw-semibold mb-1">Bước 3: Đặt mật khẩu mới</div>
                        <div class="muted-note">Đặt mật khẩu mới để đăng nhập vào tài khoản @<?php echo htmlspecialchars($username); ?>.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu mới *</label>
                        <input type="password" name="new_password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nhập lại mật khẩu mới *</label>
                        <input type="password" name="confirm_new_password" class="form-control" required placeholder="Xác nhận lại mật khẩu mới">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/phamgiahuy/account/forgotPassword?action=reset" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Bắt đầu lại</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold">Đặt lại mật khẩu</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
