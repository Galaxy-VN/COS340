<?php $title = 'Danh sách danh mục'; ?>
<?php $categories = $categories ?? []; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-folder-tree"></i>
            <span>Category manager</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Danh sách danh mục</h1>
        <p class="lead mb-0">Sắp xếp danh mục khoa học để việc quản trị sản phẩm nhanh và rõ ràng.</p>
    </div>
    <a href="/phamgiahuy/Category/add" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-plus me-2"></i>Thêm danh mục
    </a>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="surface-card p-3 h-100">
            <div class="small text-uppercase fw-semibold muted-note mb-2">Tổng danh mục</div>
            <div class="h2 mb-0 fw-bold"><?php echo count($categories); ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="surface-card p-3 h-100 d-flex align-items-center justify-content-between">
            <div>
                <div class="small text-uppercase fw-semibold muted-note mb-1">Tạo nhanh</div>
                <div class="fw-semibold">Thêm danh mục mới</div>
            </div>
            <a href="/phamgiahuy/Category/add" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tạo mới</a>
        </div>
    </div>
</div>

<div class="surface-card p-3 p-lg-4">
    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 84px; height: 84px;">
                <i class="fas fa-folder-open fa-2x text-primary"></i>
            </div>
            <h4 class="fw-semibold mb-2">Chưa có danh mục</h4>
            <p class="mb-4">Tạo danh mục đầu tiên để phân loại sản phẩm rõ ràng hơn.</p>
            <a href="/phamgiahuy/Category/add" class="btn btn-primary">Tạo danh mục</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 90px;">#</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th style="width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?php echo $category->id; ?></span></td>
                            <td>
                                <div class="fw-semibold"><?php echo htmlspecialchars($category->name); ?></div>
                                <div class="small muted-note">Danh mục #<?php echo $category->id; ?></div>
                            </td>
                            <td class="text-muted"><?php echo htmlspecialchars($category->description); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="/phamgiahuy/Category/edit/<?php echo $category->id; ?>" class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/phamgiahuy/Category/delete/<?php echo $category->id; ?>" class="btn btn-outline-danger" onclick="return confirm('Xóa?')">
                                        <i class="fas fa-trash"></i>
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
