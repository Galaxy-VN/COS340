<?php $title = 'Hồ sơ cá nhân'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-id-card"></i>
            <span>Thông tin tài khoản</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Hồ sơ cá nhân</h1>
        <p class="lead mb-0">Quản lý thông tin hiển thị, đổi mật khẩu và cập nhật ảnh đại diện của bạn.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-arrow-left me-2"></i>Quay lại cửa hàng
    </a>
</div>

<div class="row g-4">
    <!-- Cột bên trái: Tổng quan tài khoản -->
    <div class="col-lg-4">
        <div class="surface-card p-4 text-center">
            <div class="d-flex flex-column align-items-center mb-3">
                <div class="position-relative mb-3">
                    <?php if (!empty($account->avatar) && file_exists('uploads/' . $account->avatar)): ?>
                        <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($account->avatar); ?>" 
                             class="rounded-circle border border-primary shadow-sm" 
                             style="width: 130px; height: 130px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" 
                             style="width: 130px; height: 130px; font-size: 2.5rem; background: linear-gradient(135deg, var(--primary) 0%, #4f46e5 100%);">
                            <?php echo strtoupper(substr($account->username, 0, 2)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <h4 class="fw-bold mb-1 text-main"><?php echo htmlspecialchars($account->fullname); ?></h4>
                <p class="text-soft mb-2">@<?php echo htmlspecialchars($account->username); ?></p>
                <div class="d-inline-flex align-items-center gap-1 badge bg-<?php echo $account->role === 'admin' ? 'danger' : 'primary'; ?> bg-opacity-25 text-<?php echo $account->role === 'admin' ? 'danger' : 'primary'; ?> border border-<?php echo $account->role === 'admin' ? 'danger' : 'primary'; ?> border-opacity-25 px-3 py-1.5 rounded-pill fs-7 fw-semibold">
                    <i class="fas <?php echo $account->role === 'admin' ? 'fa-user-shield' : 'fa-user'; ?> fa-xs"></i>
                    <span><?php echo $account->role === 'admin' ? 'Quản trị viên' : 'Thành viên'; ?></span>
                </div>
            </div>
            <div class="text-start border-top pt-3 mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-soft fs-7">Ngày tạo:</span>
                    <span class="fw-semibold text-main fs-7"><?php echo date('d/m/Y', strtotime($account->created_at)); ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-soft fs-7">Quyền truy cập:</span>
                    <span class="fw-semibold text-main fs-7"><?php echo htmlspecialchars($account->role); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột bên phải: Các form cập nhật -->
    <div class="col-lg-8">
        <!-- Form cập nhật thông tin -->
        <div class="surface-card p-3 p-lg-4 mb-4">
            <div class="field-card mb-3">
                <h5 class="fw-bold text-main mb-1"><i class="fas fa-user-edit me-2 text-primary"></i>Thay đổi thông tin</h5>
                <div class="muted-note">Cập nhật họ tên hiển thị và hình ảnh đại diện của bạn.</div>
            </div>
            
            <form action="/phamgiahuy/account/updateProfile" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action_type" value="update_info">
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên tài khoản (Không thể thay đổi)</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($account->username); ?>" disabled style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Họ và tên *</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($account->fullname); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ảnh đại diện (Avatar)</label>
                    <div class="input-group">
                        <input type="file" name="avatar" class="form-control" accept="image/png, image/jpeg, image/jpg, image/gif, image/webp" id="avatarFileInput">
                    </div>
                    <div class="form-text text-soft fs-8 mt-1">Định dạng hỗ trợ: JPG, JPEG, PNG, GIF, WEBP. Dung lượng tối đa 2MB.</div>
                </div>

                <div class="d-grid d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Lưu thông tin
                    </button>
                </div>
            </form>
        </div>

        <!-- Form đổi mật khẩu -->
        <div class="surface-card p-3 p-lg-4">
            <div class="field-card mb-3">
                <h5 class="fw-bold text-main mb-1"><i class="fas fa-key me-2 text-warning"></i>Đổi mật khẩu</h5>
                <div class="muted-note">Hãy nhập mật khẩu hiện tại để xác nhận quyền thay đổi mật khẩu của bạn.</div>
            </div>

            <form action="/phamgiahuy/account/updateProfile" method="POST">
                <input type="hidden" name="action_type" value="update_password">

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-semibold mb-0">Mật khẩu hiện tại *</label>
                        <a href="/phamgiahuy/account/forgotPassword?action=reset" class="text-soft fs-7 text-decoration-none"><i class="fas fa-circle-question me-1"></i>Quên mật khẩu hiện tại?</a>
                    </div>
                    <input type="password" name="current_password" class="form-control" required placeholder="Nhập mật khẩu đang sử dụng">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mật khẩu mới *</label>
                        <input type="password" name="new_password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nhập lại mật khẩu mới *</label>
                        <input type="password" name="confirm_new_password" class="form-control" required placeholder="Xác nhận lại mật khẩu mới">
                    </div>
                </div>

                <div class="d-grid d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-warning px-4 text-dark fw-bold">
                        <i class="fas fa-lock-open me-2"></i>Cập nhật mật khẩu
                    </button>
                </div>
            </form>
        </div>

        <!-- Form cài đặt câu hỏi bảo mật -->
        <div class="surface-card p-3 p-lg-4 mt-4">
            <div class="field-card mb-3">
                <h5 class="fw-bold text-main mb-1"><i class="fas fa-shield-halved me-2 text-info"></i>Cài đặt câu hỏi bảo mật</h5>
                <div class="muted-note">Các câu hỏi này sẽ được sử dụng để khôi phục mật khẩu nếu bạn lỡ quên. Hãy điền các câu trả lời dễ nhớ nhất đối với bạn (không phân biệt chữ hoa, chữ thường).</div>
            </div>

            <form action="/phamgiahuy/account/updateProfile" method="POST">
                <input type="hidden" name="action_type" value="update_security">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Câu hỏi 1: Tên con vật cưng đầu tiên của bạn là gì? *</label>
                    <input type="text" name="security_a1" class="form-control" required placeholder="<?php echo !empty($account->security_a1) ? 'Đã thiết lập câu trả lời (Có thể nhập để ghi đè)' : 'Nhập câu trả lời của bạn'; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Câu hỏi 2: Tên trường tiểu học của bạn là gì? *</label>
                    <input type="text" name="security_a2" class="form-control" required placeholder="<?php echo !empty($account->security_a2) ? 'Đã thiết lập câu trả lời (Có thể nhập để ghi đè)' : 'Nhập câu trả lời của bạn'; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Câu hỏi 3: Sở thích lớn nhất của bạn là gì? *</label>
                    <input type="text" name="security_a3" class="form-control" required placeholder="<?php echo !empty($account->security_a3) ? 'Đã thiết lập câu trả lời (Có thể nhập để ghi đè)' : 'Nhập câu trả lời của bạn'; ?>">
                </div>

                <div class="d-grid d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-info px-4 text-dark fw-bold">
                        <i class="fas fa-shield me-2"></i>Lưu câu hỏi bảo mật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
