<?php $title = 'Thêm sản phẩm'; ?>
<?php $categories = $categories ?? []; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-plus-circle"></i>
            <span>New item</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Thêm sản phẩm mới</h1>
        <p class="lead mb-0">Điền thông tin cốt lõi để sản phẩm xuất hiện ngay trong danh sách quản trị.</p>
    </div>
    <a href="/phamgiahuy/Product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="surface-card p-3 p-lg-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger border-0 rounded-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/phamgiahuy/Product/save" method="POST" enctype="multipart/form-data">
                <div class="field-card mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-circle-info text-primary"></i>
                        <div class="fw-semibold">Thông tin cơ bản</div>
                    </div>
                    <div class="muted-note">Các trường có dấu * là bắt buộc trước khi lưu.</div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold">Tên sản phẩm *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">Danh mục *</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>" <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">Giá *</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" step="0.01" min="0" required>
                    </div>

                    <div class="col-md-12">
                        <label for="image" class="form-label fw-semibold">Hình ảnh</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="muted-note d-block mt-2">Hỗ trợ JPG, PNG, GIF, WEBP. Nếu không chọn ảnh, hệ thống dùng ảnh đại diện mặc định.</small>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Lưu
                    </button>
                    <a href="/phamgiahuy/Product" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
