<?php $title = 'Thanh toán đơn hàng'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-credit-card"></i>
            <span>Checkout</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Thanh Toán Đơn Hàng</h1>
        <p class="lead mb-0">Vui lòng cung cấp thông tin giao hàng để hoàn tất việc mua sắm.</p>
    </div>
    <a href="/phamgiahuy/Product/cart" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-arrow-left me-2"></i>Trở lại giỏ hàng
    </a>
</div>

<div class="row g-4">
    <!-- Form thông tin khách hàng -->
    <div class="col-lg-7">
        <div class="surface-card p-4">
            <h4 class="mb-4 fw-bold">Thông tin giao hàng</h4>
            <form action="/phamgiahuy/Product/processCheckout" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Họ và Tên *</label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Ví dụ: Nguyễn Văn A" required>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Số điện thoại *</label>
                    <input type="tel" class="form-control form-control-lg" id="phone" name="phone" placeholder="Ví dụ: 0912345678" required>
                </div>
                
                <div class="mb-4">
                    <label for="address" class="form-label fw-bold">Địa chỉ giao hàng chi tiết *</label>
                    <textarea class="form-control form-control-lg" id="address" name="address" rows="3" placeholder="Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố..." required></textarea>
                </div>

                <hr class="my-4 border-secondary opacity-25">
                
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-shield-halved text-success"></i>
                    <span class="small text-muted">Phương thức thanh toán mặc định: <b>Thanh toán khi nhận hàng (COD)</b>.</span>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                        Xác nhận đặt hàng & Tổng: <?php echo number_format($subtotal, 0, ',', '.'); ?>đ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tóm tắt đơn hàng -->
    <div class="col-lg-5">
        <div class="surface-card p-4 position-sticky" style="top: 1rem;">
            <h4 class="mb-4 fw-bold">Tóm tắt đơn hàng (<?php echo count($items); ?> sản phẩm)</h4>
            
            <div class="order-items-scroll pe-2 mb-4" style="max-height: 300px; overflow-y: auto;">
                <?php foreach ($items as $item): ?>
                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom border-secondary border-opacity-10 align-items-center">
                        <div class="rounded-3 overflow-hidden bg-light border" style="width: 60px; height: 60px; flex-shrink: 0;">
                            <?php if (!empty($item['image'])): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($item['image']); ?>" class="w-100 h-100" style="object-fit: cover;">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="fas fa-image"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold fs-6"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="text-muted small">Mã #<?php echo $item['id']; ?> &times; <?php echo $item['quantity']; ?></div>
                        </div>
                        <div class="fw-bold text-end">
                            <?php echo number_format($item['line_total'], 0, ',', '.'); ?>đ
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Tạm tính:</span>
                <span class="fw-semibold text-end"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
            </div>
            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-secondary border-opacity-10">
                <span class="text-muted">Phí vận chuyển:</span>
                <span class="fw-semibold text-end">Miễn phí</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <span class="h5 fw-bold mb-0">Tổng thanh toán:</span>
                <span class="h4 fw-bold text-primary mb-0"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>