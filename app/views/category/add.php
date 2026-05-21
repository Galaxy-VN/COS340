<?php $title = 'Thêm danh mục'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-folder-plus"></i>
            <span>New category</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Thêm danh mục</h1>
        <p class="lead mb-0">Tạo nhóm sản phẩm mới với form tối giản và dễ đọc.</p>
    </div>
    <a href="/phamgiahuy/Category" class="btn btn-light text-primary fw-semibold shadow-sm">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">
        <div class="surface-card p-3 p-lg-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger border-0 rounded-4">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="/phamgiahuy/Category/save" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên *</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Lưu</button>
                    <a href="/phamgiahuy/Category" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
