<?php $title = 'Chi tiết đơn hàng ' . htmlspecialchars($order['id']); ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-file-invoice"></i>
            <span>Order Detail</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Chi tiết đơn hàng #<?php echo htmlspecialchars($order['id']); ?></h1>
        <p class="lead mb-0">Đặt lúc <?php echo date('H:i d/m/Y', strtotime($order['date'])); ?> - Trạng thái: Đang xử lý</p>
    </div>
    <a href="/phamgiahuy/product/orders" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index: 1;">
        <i class="fas fa-arrow-left me-2"></i>Trở lại danh sách
    </a>
</div>

<div class="row g-4 mt-1">
    <!-- Thông tin khách hàng & Giao hàng -->
    <div class="col-lg-4">
        <div class="surface-card p-4 h-100">
            <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-location-dot text-primary"></i>
                Thông tin nhận hàng
            </h5>
            <div class="mb-3">
                <div class="text-white small text-uppercase fw-bold mb-1">Người nhận</div>
                <div class="fw-semibold fs-5"><?php echo htmlspecialchars($order['customer']['name']); ?></div>
            </div>
            <div class="mb-3">
                <div class="text-white small text-uppercase fw-bold mb-1">Số điện thoại</div>
                <div class="fw-semibold fs-6"><?php echo htmlspecialchars($order['customer']['phone']); ?></div>
            </div>
            <div class="mb-3">
                <div class="text-white small text-uppercase fw-bold mb-1">Địa chỉ giao hàng (COD)</div>
                <div class="fs-6"><?php echo nl2br(htmlspecialchars($order['customer']['address'])); ?></div>
            </div>
            
            <div class="mt-4 p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3 d-flex align-items-start gap-3">
                <i class="fas fa-circle-info text-primary mt-1"></i>
                <div class="small">Đơn hàng đang chờ nhân viên liên hệ xác nhận trước khi giao hàng.</div>
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="col-lg-8">
        <div class="surface-card p-4 h-100">
            <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-box-open text-primary"></i>
                Sản phẩm đã đặt (<?php echo count($order['items']); ?>)
            </h5>
            
            <div class="table-responsive">
                <table class="table align-middle mb-4">
                    <thead>
                        <tr>
                            <th class="ps-0">Sản phẩm</th>
                            <th class="text-center" style="width: 100px;">Giá</th>
                            <th class="text-center" style="width: 100px;">SL</th>
                            <th class="text-end pe-0" style="width: 120px;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td class="ps-0 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded-3 overflow-hidden border d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; flex-shrink: 0;">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($item['image']); ?>" class="w-100 h-100 object-fit-cover">
                                            <?php else: ?>
                                                <i class="fas fa-image text-muted"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-wrap">
                                                <?php if (!empty($item['product_id'])): ?>
                                                    <a href="/phamgiahuy/product/show/<?php echo (int)$item['product_id']; ?>" class="text-decoration-none text-reset">
                                                        <?php echo htmlspecialchars($item['name']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="small text-muted">Mã: #<?php echo htmlspecialchars($item['product_id'] ?? '—'); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-3 fw-semibold"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                <td class="text-center py-3">x<?php echo $item['quantity']; ?></td>
                                <td class="text-end pe-0 py-3 fw-bold text-primary"><?php echo number_format($item['line_total'], 0, ',', '.'); ?>đ</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="ps-0 pb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (!empty($item['product_id'])): ?>
                                                <form action="/phamgiahuy/product/addToCart" method="POST" class="d-inline">
                                                    <input type="hidden" name="product_id" value="<?php echo (int)$item['product_id']; ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input type="hidden" name="redirect_to" value="/phamgiahuy/product/orderDetail/<?php echo urlencode($order['id']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-glass">
                                                        <i class="fas fa-cart-plus"></i>
                                                        Mua lại
                                                    </button>
                                                </form>
                                                <a href="/phamgiahuy/product/show/<?php echo (int)$item['product_id']; ?>" class="btn btn-sm btn-glass">
                                                    <i class="fas fa-eye"></i>
                                                    Xem chi tiết
                                                </a>
                                            <?php else: ?>
                                                <span class="small text-muted">Sản phẩm đã bị xóa khỏi cửa hàng</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <div style="width: 300px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white">Tổng tiền hàng:</span>
                        <span class="fw-semibold"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                        <span class="text-white">Phí giao hàng:</span>
                        <span class="fw-semibold">Miễn phí</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <span class="fs-5 fw-bold mb-0">Thành tiền:</span>
                        <span class="fs-3 fw-bold text-primary mb-0"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>