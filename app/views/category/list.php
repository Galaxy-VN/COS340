<?php $title = 'Danh sách danh mục'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-dark">
            <i class="fas fa-folder-open me-2 text-primary"></i>Danh mục
        </h4>
        <a href="/phamgiahuy/Category/add" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($categories)): ?>
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-2">Chưa có danh mục</p>
                <a href="/phamgiahuy/Category/add" class="btn btn-primary">Tạo danh mục</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?php echo $category->id; ?></span></td>
                                <td><strong><?php echo htmlspecialchars($category->name); ?></strong></td>
                                <td><?php echo htmlspecialchars($category->description); ?></td>
                                <td>
                                    <a href="/phamgiahuy/Category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/phamgiahuy/Category/delete/<?php echo $category->id; ?>"
                                       class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
