<?php $title = 'Danh sách sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-dark">
            <i class="fas fa-boxes me-2 text-primary"></i>Danh sách sản phẩm
        </h4>
        <a href="/phamgiahuy/Product/add" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm mới
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-2">Chưa có sản phẩm nào</p>
                <a href="/phamgiahuy/Product/add" class="btn btn-primary">Thêm sản phẩm đầu tiên</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table id="productTable" class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">Ảnh</th>
                            <th style="width: 60px;">#</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th style="width: 120px;">Giá</th>
                            <th style="width: 130px;">Danh mục</th>
                            <th style="width: 100px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                        <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>"
                                             alt="Ảnh" class="img-thumbnail" width="60" height="60">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 8px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-secondary"><?php echo $product->id; ?></span></td>
                                <td><strong><?php echo htmlspecialchars($product->name); ?></strong></td>
                                <td class="text-truncate" style="max-width: 300px;"><?php echo htmlspecialchars($product->description); ?></td>
                                <td><span class="text-primary fw-medium"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span></td>
                                <td><span class="badge bg-info bg-opacity-25 text-info"><?php echo htmlspecialchars($product->category_name ?? '—'); ?></span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="/phamgiahuy/Product/edit/<?php echo $product->id; ?>" class="btn btn-outline-warning" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/phamgiahuy/Product/delete/<?php echo $product->id; ?>" class="btn btn-outline-danger"
                                           onclick="return confirm('Xóa sản phẩm này?')" title="Xóa">
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
</div>

<?php include 'app/views/layout/footer.php'; ?>
