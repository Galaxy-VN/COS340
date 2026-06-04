<?php $title = 'Chỉnh sửa danh mục • COS340 Store'; ?>
<?php $category = $category ?? (object) ['id' => '', 'name' => '', 'description' => '']; ?>
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
            <i class="ph ph-pencil-simple-line text-primary"></i>
            <span>Sửa danh mục</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Chỉnh Sửa Danh Mục</h1>
        <p class="text-muted mb-0">Cập nhật nhanh tên và thông tin mô tả danh mục phân loại.</p>
    </div>
    <a href="/phamgiahuy/category" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="surface-card p-4">
            <form action="/phamgiahuy/category/update" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($category->id); ?>">

                <div class="field-card mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-white mb-1">Mã danh mục: #<?php echo $category->id; ?></h5>
                        <div class="text-muted small">Cập nhật thông tin phân loại để đồng bộ bộ lọc cửa hàng.</div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10 px-2.5 py-1.5">Chế độ sửa</span>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên danh mục *</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category->name); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Mô tả phân loại</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($category->description); ?></textarea>
                </div>

                <div class="mt-4 pt-3 border-top border-white border-opacity-5 d-flex gap-2">
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2.5 rounded-3 d-flex align-items-center gap-1">
                        <i class="ph ph-floppy-disk-back"></i> Cập nhật danh mục
                    </button>
                    <a href="/phamgiahuy/category" class="btn btn-glass px-4 py-2.5 rounded-3">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
