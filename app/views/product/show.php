<?php $title = 'Chi tiết sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-eye"></i>
            <span>Product detail</span>
        </div>
        <h1 class="h3 mb-2 fw-bold"><?php echo htmlspecialchars($product->name); ?></h1>
        <p class="lead mb-0">Xem nhanh thông tin sản phẩm và chuyển sang chỉnh sửa nếu cần.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/phamgiahuy/Product" class="btn btn-light text-primary fw-semibold shadow-sm"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
        <a href="/phamgiahuy/Product/edit/<?php echo $product->id; ?>" class="btn btn-dark fw-semibold"><i class="fas fa-pen-to-square me-2"></i>Chỉnh sửa</a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="surface-card p-3 p-lg-4">
            <div class="row g-4 align-items-start">
                <div class="col-md-5">
                    <div class="rounded-4 overflow-hidden bg-light d-flex align-items-center justify-content-center" style="min-height: 320px;">
                        <?php if ($product->image): ?>
                            <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="Ảnh sản phẩm" class="img-fluid w-100 h-100" style="max-height: 420px; object-fit: cover;">
                        <?php else: ?>
                            <i class="fas fa-image fa-3x text-muted"></i>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-secondary">ID: <?php echo $product->id; ?></span>
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25"><?php echo htmlspecialchars($category->name ?? '—'); ?></span>
                    </div>
                    <h2 class="h4 fw-bold mb-3"><?php echo htmlspecialchars($product->name); ?></h2>
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Giá</div>
                        <div class="fs-3 fw-bold text-primary"><?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Mô tả</div>
                        <div class="text-body-emphasis lh-lg"><?php echo nl2br(htmlspecialchars($product->description)); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>