<?php $title = 'Thêm sản phẩm • COS340 Store'; ?>
<?php $categories = $categories ?? []; ?>
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
            <i class="ph ph-plus-circle text-primary"></i>
            <span>Thêm mới</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Thêm Sản Phẩm Mới</h1>
        <p class="text-muted mb-0">Cung cấp thông tin chi tiết thiết bị để xuất hiện trên trang bán hàng.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
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

            <form action="/phamgiahuy/product/save" method="POST" enctype="multipart/form-data">
                <div class="field-card mb-4 text-center text-md-start">
                    <h5 class="fw-bold text-white mb-1"><i class="ph ph-notebook text-primary me-1"></i> Nhập thông tin chi tiết</h5>
                    <div class="text-muted small">Tên sản phẩm, giá bán, danh mục và hình ảnh minh họa.</div>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên sản phẩm *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required placeholder="Ví dụ: iPhone 14 Pro Max">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Mô tả chi tiết</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Nhập mô tả sản phẩm, cấu hình, đặc điểm..."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Danh mục thiết bị *</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>" <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Giá bán (VNĐ) *</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" step="0.01" min="0" required placeholder="Nhập giá sản phẩm">
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Ảnh minh họa sản phẩm</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="text-muted small mt-2">Hỗ trợ định dạng JPG, PNG, GIF, WEBP. Dung lượng tối đa 5MB.</div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top border-white border-opacity-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2.5 rounded-3 d-flex align-items-center gap-1">
                        <i class="ph ph-floppy-disk"></i> Lưu thiết bị
                    </button>
                    <a href="/phamgiahuy/product" class="btn btn-glass px-4 py-2.5 rounded-3">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
