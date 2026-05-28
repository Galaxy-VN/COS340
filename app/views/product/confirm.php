<?php $title = 'Xác nhận đơn hàng'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="surface-card p-5 text-center mt-4">
    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10" style="width: 120px; height: 120px;">
        <i class="fas fa-check fa-3x text-success"></i>
    </div>
    <h2 class="fw-bold mb-2">Cảm ơn bạn! Đơn hàng của bạn đã được đặt.</h2>
    <p class="text-muted mb-4">Mã đơn hàng của bạn: <strong>#<?php echo htmlspecialchars($order['id']); ?></strong></p>

    <div class="d-flex justify-content-center gap-3">
        <a href="/phamgiahuy/Product" class="btn btn-primary btn-lg rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Quay về cửa hàng
        </a>
        <a href="/phamgiahuy/Product/orderDetail/<?php echo urlencode($order['id']); ?>" class="btn btn-outline-primary btn-lg rounded-pill">
            <i class="fas fa-eye me-2"></i>Xem chi tiết đơn hàng
        </a>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
