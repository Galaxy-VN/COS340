<?php $title = 'Đặt hàng thành công • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="surface-card p-5 text-center mt-5">
            <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10" style="width: 100px; height: 100px; border: 1px solid rgba(16, 185, 129, 0.2);">
                <i class="ph ph-check-circle text-success" style="font-size: 3.5rem;"></i>
            </div>
            <h2 class="fw-bold text-white mb-2">Đặt Hàng Thành Công!</h2>
            <p class="text-muted mb-4">Cảm ơn bạn đã lựa chọn mua sắm tại cửa hàng của chúng tôi.</p>
            
            <div class="field-card mb-4 text-center py-3">
                <div class="small text-muted text-uppercase tracking-wider fw-semibold mb-1">Mã đơn hàng của bạn</div>
                <div class="fs-4 fw-bold text-primary">#<?php echo htmlspecialchars($order['id']); ?></div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="/phamgiahuy/product" class="btn btn-primary px-4 py-2.5 rounded-3 d-flex align-items-center gap-2">
                    <i class="ph ph-storefront"></i> Quay về cửa hàng
                </a>
                <a href="/phamgiahuy/product/orderDetail/<?php echo urlencode($order['id']); ?>" class="btn btn-glass px-4 py-2.5 rounded-3 d-flex align-items-center gap-2">
                    <i class="ph ph-receipt"></i> Xem chi tiết đơn hàng
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
