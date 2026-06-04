<?php $title = 'Hồ sơ cá nhân • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Profile Page -->
<style>
    .profile-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
</style>

<!-- Profile Hero Header -->
<div class="profile-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-user text-primary"></i>
            <span>Thông tin cá nhân</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Hồ Sơ Cá Nhân</h1>
        <p class="text-muted mb-0">Quản lý cài đặt tài khoản, thay đổi ảnh đại diện và thiết lập các câu hỏi bảo mật.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-storefront"></i> Quay lại cửa hàng
    </a>
</div>

<div class="row g-4">
    <!-- Left Column: User Card -->
    <div class="col-lg-4">
        <div class="surface-card p-4 text-center">
            <div class="d-flex flex-column align-items-center mb-3">
                <div class="position-relative mb-3">
                    <?php if (!empty($account->avatar) && file_exists('uploads/' . $account->avatar)): ?>
                        <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($account->avatar); ?>" 
                             class="rounded-circle border border-primary" 
                             style="width: 120px; height: 120px; object-fit: cover; box-shadow: 0 0 20px rgba(59,130,246,0.3);">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm mx-auto" 
                             style="width: 120px; height: 120px; font-size: 2.5rem; background: linear-gradient(135deg, var(--brand-500) 0%, var(--accent) 100%);">
                            <?php echo strtoupper(substr($account->username, 0, 2)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <h4 class="fw-bold text-white mb-1"><?php echo htmlspecialchars($account->fullname); ?></h4>
                <p class="text-muted small mb-3">@<?php echo htmlspecialchars($account->username); ?></p>
                
                <div class="d-inline-flex align-items-center gap-1.5 badge bg-primary-subtle text-primary border border-primary border-opacity-10 px-3 py-1.5 rounded-pill fs-7 fw-semibold">
                    <i class="ph ph-user-circle fa-xs"></i>
                    <span><?php echo $account->role === 'admin' ? 'Quản trị viên' : 'Khách hàng'; ?></span>
                </div>
            </div>
            
            <div class="text-start border-top border-white border-opacity-5 pt-3 mt-4">
                <div class="d-flex justify-content-between mb-2 small text-muted">
                    <span>Thành viên từ:</span>
                    <span class="fw-semibold text-white"><?php echo date('d/m/Y', strtotime($account->created_at)); ?></span>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span>Quyền truy cập:</span>
                    <span class="fw-semibold text-white font-monospace"><?php echo htmlspecialchars($account->role); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Settings Forms -->
    <div class="col-lg-8">
        <!-- Info Form -->
        <div class="surface-card p-4 mb-4">
            <div class="field-card mb-4">
                <h5 class="fw-bold text-white mb-1"><i class="ph ph-user-focus text-primary me-1"></i> Thay đổi thông tin cá nhân</h5>
                <div class="text-muted small">Cập nhật thông tin hiển thị và ảnh đại diện mới.</div>
            </div>
            
            <form action="/phamgiahuy/account/updateProfile" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action_type" value="update_info">
                
                <div class="mb-3">
                    <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên tài khoản (Không thể sửa)</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($account->username); ?>" disabled style="background-color: rgba(15, 23, 42, 0.4); border-color: rgba(255,255,255,0.06); color: var(--text-soft);">
                </div>
                
                <div class="mb-3">
                    <label for="fullname" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Họ và tên *</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo htmlspecialchars($account->fullname); ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="avatar" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tải ảnh đại diện mới</label>
                    <input type="file" name="avatar" id="avatar" class="form-control" accept="image/png, image/jpeg, image/jpg, image/gif, image/webp">
                    <div class="text-muted small mt-2">Dung lượng file tối đa 2MB. Hỗ trợ JPG, PNG, WEBP.</div>
                </div>

                <div class="d-flex justify-content-end pt-2 border-top border-white border-opacity-5">
                    <button type="submit" class="btn btn-primary px-4 py-2.5 rounded-3 d-flex align-items-center gap-1">
                        <i class="ph ph-floppy-disk"></i> Lưu thông tin
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Password Form -->
        <div class="surface-card p-4 mb-4">
            <div class="field-card mb-4">
                <h5 class="fw-bold text-white mb-1"><i class="ph ph-lock text-warning me-1"></i> Thay đổi mật khẩu bảo mật</h5>
                <div class="text-muted small">Cần xác nhận mật khẩu hiện tại trước khi tạo mật khẩu mới.</div>
            </div>

            <form action="/phamgiahuy/account/updateProfile" method="POST">
                <input type="hidden" name="action_type" value="update_password">

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="current_password" class="form-label text-muted small text-uppercase tracking-wider fw-semibold mb-0">Mật khẩu hiện tại *</label>
                        <a href="/phamgiahuy/account/forgotPassword?action=reset" class="small text-primary text-decoration-none" style="font-size: 0.8rem;">Quên mật khẩu hiện tại?</a>
                    </div>
                    <input type="password" name="current_password" id="current_password" class="form-control" required placeholder="Nhập mật khẩu đang dùng...">
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="new_password" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Mật khẩu mới *</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                    </div>
                    <div class="col-md-6">
                        <label for="confirm_new_password" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Xác nhận mật khẩu mới *</label>
                        <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" required placeholder="Nhập lại mật khẩu mới">
                    </div>
                </div>

                <div class="d-flex justify-content-end pt-2 border-top border-white border-opacity-5">
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2.5 rounded-3 d-flex align-items-center gap-1">
                        <i class="ph ph-key"></i> Cập nhật mật khẩu
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Questions Form -->
        <div class="surface-card p-4">
            <div class="field-card mb-4">
                <h5 class="fw-bold text-white mb-1"><i class="ph ph-shield-check text-info me-1"></i> Cài đặt câu hỏi bảo mật</h5>
                <div class="text-muted small">Dùng để khôi phục tài khoản khi mất mật khẩu. Ghi nhớ các đáp án bên dưới.</div>
            </div>

            <form action="/phamgiahuy/account/updateProfile" method="POST">
                <input type="hidden" name="action_type" value="update_security">

                <div class="mb-3">
                    <label for="security_a1" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Câu hỏi 1: Tên con vật cưng đầu tiên của bạn? *</label>
                    <input type="text" name="security_a1" id="security_a1" class="form-control" required placeholder="<?php echo !empty($account->security_a1) ? 'Đã thiết lập câu trả lời (Nhập để thay đổi)' : 'Nhập đáp án của bạn...'; ?>">
                </div>

                <div class="mb-3">
                    <label for="security_a2" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Câu hỏi 2: Tên trường tiểu học của bạn? *</label>
                    <input type="text" name="security_a2" id="security_a2" class="form-control" required placeholder="<?php echo !empty($account->security_a2) ? 'Đã thiết lập câu trả lời (Nhập để thay đổi)' : 'Nhập đáp án của bạn...'; ?>">
                </div>

                <div class="mb-4">
                    <label for="security_a3" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Câu hỏi 3: Sở thích lớn nhất của bạn là gì? *</label>
                    <input type="text" name="security_a3" id="security_a3" class="form-control" required placeholder="<?php echo !empty($account->security_a3) ? 'Đã thiết lập câu trả lời (Nhập để thay đổi)' : 'Nhập đáp án của bạn...'; ?>">
                </div>

                <div class="d-flex justify-content-end pt-2 border-top border-white border-opacity-5">
                    <button type="submit" class="btn btn-info text-dark fw-bold px-4 py-2.5 rounded-3 d-flex align-items-center gap-1">
                        <i class="ph ph-shield-check"></i> Lưu câu hỏi bảo mật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
