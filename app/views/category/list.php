<?php $title = 'Danh sách danh mục'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-folder-tree"></i>
            <span>Category manager</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Danh sách danh mục</h1>
        <p class="lead mb-0">Tổ chức danh mục gọn gàng, dễ nhìn và dễ thao tác hơn.</p>
    </div>
    <a href="/phamgiahuy/Category/add" class="btn btn-light text-primary fw-semibold shadow-sm">
        <i class="fas fa-plus me-2"></i>Thêm danh mục
    </a>
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
                            <td class="fw-semibold"><?php echo htmlspecialchars($category->name); ?></td>
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
