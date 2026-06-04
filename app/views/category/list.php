<?php $title = 'Quản lý danh mục • COS340 Store'; ?>
<?php $categories = $categories ?? []; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Category Page -->
<style>
    .category-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
</style>

<!-- Category Hero Header -->
<div class="category-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-folder text-primary"></i>
            <span>Danh mục sản phẩm</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Quản Lý Danh Mục</h1>
        <p class="text-muted mb-0">Thiết lập các danh mục sản phẩm để người dùng lọc và tìm kiếm thiết bị dễ dàng hơn.</p>
    </div>
    <a href="/phamgiahuy/category/add" class="btn btn-primary fw-semibold d-flex align-items-center gap-2">
        <i class="ph ph-plus-circle"></i> Thêm danh mục mới
    </a>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="surface-card p-3 h-100 d-flex flex-column justify-content-between">
            <div class="small text-uppercase tracking-wider text-muted fw-semibold mb-2">Tổng số danh mục</div>
            <div class="d-flex align-items-end justify-content-between mt-auto">
                <div class="h3 mb-0 fw-bold"><?php echo count($categories); ?> loại</div>
                <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10">Kích hoạt</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="surface-card p-3 h-100 d-flex align-items-center justify-content-between">
            <div>
                <div class="small text-uppercase tracking-wider text-muted mb-1">Thao tác nhanh</div>
                <div class="fw-semibold text-white">Quay lại cửa hàng chính</div>
            </div>
            <a href="/phamgiahuy/product" class="btn btn-glass btn-sm px-3"><i class="ph ph-storefront me-1"></i> Cửa hàng</a>
        </div>
    </div>
</div>

<div class="surface-card p-4">
    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 80px; height: 80px;">
                <i class="ph ph-folder-open fa-2x text-primary"></i>
            </div>
            <h4 class="fw-bold text-white mb-2">Chưa có danh mục nào</h4>
            <p class="text-muted mb-4">Hãy tạo danh mục đầu tiên để phân phối và tổ chức hệ thống sản phẩm.</p>
            <a href="/phamgiahuy/category/add" class="btn btn-primary px-4 py-2 rounded-3">Tạo danh mục mới</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 100px;"># ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả chi tiết</th>
                        <th style="width: 140px;" class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <span class="badge bg-dark bg-opacity-30 text-white border border-white border-opacity-10 px-2.5 py-1.5 font-monospace">
                                    #<?php echo $category->id; ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-white"><?php echo htmlspecialchars($category->name); ?></div>
                                <div class="small text-muted">ID Phân loại: <?php echo $category->id; ?></div>
                            </td>
                            <td class="text-white-50"><?php echo htmlspecialchars($category->description); ?></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="/phamgiahuy/category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-glass text-warning px-2.5 py-2" title="Chỉnh sửa">
                                        <i class="ph ph-pencil-simple" style="font-size: 1.15rem;"></i>
                                    </a>
                                    <a href="/phamgiahuy/category/delete/<?php echo $category->id; ?>" class="btn btn-sm btn-glass text-danger px-2.5 py-2" title="Xóa bỏ" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                        <i class="ph ph-trash" style="font-size: 1.15rem;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/layout/footer.php'; ?>
