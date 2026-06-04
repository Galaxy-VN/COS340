<?php $title = 'Thêm danh mục • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Form Page -->
<style>
    .form-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
</style>

<!-- Form Hero Header -->
<div class="form-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-folder-plus text-primary"></i>
            <span>Thêm mới danh mục</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Thêm Danh Mục Mới</h1>
        <p class="text-muted mb-0">Tạo một phân loại sản phẩm mới để giúp người mua hàng dễ tìm kiếm thiết bị.</p>
    </div>
    <a href="/phamgiahuy/category" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="surface-card p-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <div class="fw-bold mb-1"><i class="ph ph-warning-circle"></i> Vui lòng sửa các lỗi sau:</div>
                    <ul class="mb-0 ps-3 small">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/phamgiahuy/category/save" method="POST">
                <div class="field-card mb-4">
                    <h5 class="fw-bold text-white mb-1"><i class="ph ph-note text-primary me-1"></i> Chi tiết phân loại</h5>
                    <div class="text-muted small">Tên danh mục nên ngắn gọn, súc tích (ví dụ: Điện thoại, Laptop, Phụ kiện).</div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên danh mục *</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required placeholder="Nhập tên phân loại...">
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Mô tả phân loại</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Nhập một vài mô tả ngắn về danh mục này..."></textarea>
                </div>

                <div class="mt-4 pt-3 border-top border-white border-opacity-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2.5 rounded-3 d-flex align-items-center gap-1">
                        <i class="ph ph-floppy-disk"></i> Lưu danh mục
                    </button>
                    <a href="/phamgiahuy/category" class="btn btn-glass px-4 py-2.5 rounded-3">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
