<?php $title = 'Danh sách sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-boxes"></i>
            <span>Product catalog</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Danh sách sản phẩm</h1>
        <p class="lead mb-0">Quản lý sản phẩm theo danh mục, ảnh và giá trong một giao diện rõ ràng hơn.</p>
    </div>
    <a href="/phamgiahuy/Product/add" class="btn btn-light text-primary fw-semibold shadow-sm">
        <i class="fas fa-plus me-2"></i>Thêm sản phẩm
    </a>
</div>

<div class="surface-card p-3 p-lg-4">
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 84px; height: 84px;">
                <i class="fas fa-box-open fa-2x text-primary"></i>
            </div>
            <h4 class="fw-semibold mb-2">Chưa có sản phẩm nào</h4>
            <p class="mb-4">Hãy tạo sản phẩm đầu tiên để bắt đầu quản lý dữ liệu.</p>
            <a href="/phamgiahuy/Product/add" class="btn btn-primary">Thêm sản phẩm đầu tiên</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table id="productTable" class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 84px;">Ảnh</th>
                        <th style="width: 70px;">#</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th style="width: 140px;">Giá</th>
                        <th style="width: 150px;">Danh mục</th>
                        <th style="width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                    <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="Ảnh" class="img-thumbnail" width="64" height="64">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; border-radius: 14px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-secondary"><?php echo $product->id; ?></span></td>
                            <td class="fw-semibold"><?php echo htmlspecialchars($product->name); ?></td>
                            <td class="text-muted" style="max-width: 360px;"><?php echo htmlspecialchars($product->description); ?></td>
                            <td><span class="fw-semibold text-primary"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span></td>
                            <td><span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25"><?php echo htmlspecialchars($product->category_name ?? '—'); ?></span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="/phamgiahuy/Product/edit/<?php echo $product->id; ?>" class="btn btn-outline-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/phamgiahuy/Product/delete/<?php echo $product->id; ?>" class="btn btn-outline-danger" onclick="return confirm('Xóa sản phẩm này?')" title="Xóa">
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
