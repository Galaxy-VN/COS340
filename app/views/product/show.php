<?php $title = 'Chi tiết sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h4 class="mb-0 text-primary"><i class="fas fa-eye me-2"></i>Chi tiết sản phẩm</h4>
            </div>
            <div class="card-body px-4">
                <div class="row g-4">
                    <div class="col-md-5">
                        <?php if ($product->image): ?>
                            <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="Ảnh sản phẩm" class="img-fluid rounded-3 shadow-sm" style="max-height: 300px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-3" style="height: 300px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <h3><?php echo htmlspecialchars($product->name); ?></h3>
                        <p class="text-muted mb-2">ID: <?php echo $product->id; ?></p>
                        <p><strong>Giá:</strong> <span class="text-success fs-5"><?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ</span></p>
                        <p class="mt-3"><strong>Mô tả:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($product->description)); ?></p>
                        <p class="mt-2"><strong>Danh mục:</strong> <span class="badge bg-info"><?php echo htmlspecialchars($category->name ?? '—'); ?></span></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="/phamgiahuy/Product" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
                    <a href="/phamgiahuy/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Sửa</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>