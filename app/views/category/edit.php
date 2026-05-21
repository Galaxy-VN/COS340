<?php $title = 'Chỉnh sửa danh mục'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-pen-to-square"></i>
            <span>Edit category</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Chỉnh sửa danh mục</h1>
        <p class="lead mb-0">Cập nhật tên và mô tả danh mục trong một giao diện sạch hơn.</p>
    </div>
    <a href="/phamgiahuy/Category" class="btn btn-light text-primary fw-semibold shadow-sm">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="surface-card p-3 p-lg-4">
            <form action="/phamgiahuy/Category/update" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($category->id); ?>">

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category->name); ?>" placeholder="Nhập tên danh mục" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Nhập mô tả danh mục"><?php echo htmlspecialchars($category->description); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Cập nhật
                    </button>
                    <a href="/phamgiahuy/Category" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
