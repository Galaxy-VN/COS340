<?php $title = 'Chi tiết đơn hàng ' . htmlspecialchars($order['id']) . ' • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Order Detail Page -->
<style>
    .order-detail-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .order-detail-thumb {
        width: 64px;
        height: 64px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        flex-shrink: 0;
    }
    .order-detail-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<!-- Hero Header -->
<div class="order-detail-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-receipt text-primary"></i>
            <span>Hoá đơn chi tiết</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Đơn Hàng #<?php echo htmlspecialchars($order['id']); ?></h1>
        <p class="text-muted mb-0">Đặt lúc <?php echo date('H:i d/m/Y', strtotime($order['date'])); ?> • Phương thức COD</p>
    </div>
    <a href="/phamgiahuy/product/orders" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-arrow-left"></i> Trở lại danh sách
    </a>
</div>

<div class="row g-4">
    <!-- Customer Shipping Info -->
    <div class="col-lg-4">
        <div class="surface-card p-4 h-100">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2 pb-2 border-bottom border-white border-opacity-5">
                <i class="ph ph-map-pin text-primary"></i>
                Thông tin nhận hàng
            </h5>
            <div class="mb-3">
                <div class="text-muted small text-uppercase tracking-wider fw-semibold mb-1">Người nhận</div>
                <div class="fw-semibold text-white fs-5"><?php echo htmlspecialchars($order['customer']['name']); ?></div>
            </div>
            <div class="mb-3">
                <div class="text-muted small text-uppercase tracking-wider fw-semibold mb-1">Số điện thoại</div>
                <div class="fw-semibold text-white"><?php echo htmlspecialchars($order['customer']['phone']); ?></div>
            </div>
            <div class="mb-4">
                <div class="text-muted small text-uppercase tracking-wider fw-semibold mb-1">Địa chỉ giao hàng</div>
                <div class="text-white-50 fs-6"><?php echo nl2br(htmlspecialchars($order['customer']['address'])); ?></div>
            </div>
            
            <div class="p-3 bg-primary bg-opacity-10 border border-primary border-opacity-10 rounded-3 d-flex align-items-start gap-2">
                <i class="ph ph-info text-primary fs-5 mt-0.5"></i>
                <div class="small text-muted">Đơn hàng đang chờ nhân viên liên hệ xác thực trước khi gửi đi.</div>
            </div>
        </div>
    </div>

    <!-- Ordered Items Details -->
    <div class="col-lg-8">
        <div class="surface-card p-4 h-100">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2 pb-2 border-bottom border-white border-opacity-5">
                <i class="ph ph-package text-primary"></i>
                Danh sách thiết bị (<?php echo count($order['items']); ?>)
            </h5>
            
            <div class="table-responsive">
                <table class="table align-middle mb-4">
                    <thead>
                        <tr>
                            <th class="ps-0 text-muted">Sản phẩm</th>
                            <th class="text-center text-muted" style="width: 120px;">Đơn giá</th>
                            <th class="text-center text-muted" style="width: 80px;">SL</th>
                            <th class="text-end pe-0 text-muted" style="width: 140px;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td class="ps-0 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="order-detail-thumb">
                                            <?php if (!empty($item['image']) && file_exists('uploads/' . $item['image'])): ?>
                                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                            <?php else: ?>
                                                <div class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center">
                                                    <i class="ph ph-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-white text-wrap">
                                                <?php if (!empty($item['product_id'])): ?>
                                                    <a href="/phamgiahuy/product/show/<?php echo (int)$item['product_id']; ?>" class="text-decoration-none text-reset hover-accent">
                                                        <?php echo htmlspecialchars($item['name']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="small text-muted">Mã SP: #<?php echo htmlspecialchars($item['product_id'] ?? '—'); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-3 text-white"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                <td class="text-center py-3 text-white">x<?php echo $item['quantity']; ?></td>
                                <td class="text-end pe-0 py-3 fw-bold text-primary"><?php echo number_format($item['line_total'], 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="ps-0 pb-3 border-bottom border-white border-opacity-5">
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($item['product_id'])): ?>
                                            <form action="/phamgiahuy/product/addToCart" method="POST" class="m-0">
                                                <input type="hidden" name="product_id" value="<?php echo (int)$item['product_id']; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="redirect_to" value="/phamgiahuy/product/orderDetail/<?php echo urlencode($order['id']); ?>">
                                                <button type="submit" class="btn btn-sm btn-glass px-2.5 py-1.5 fs-7 d-flex align-items-center gap-1">
                                                    <i class="ph ph-arrows-counter-clockwise"></i> Mua lại
                                                </button>
                                            </form>
                                            <a href="/phamgiahuy/product/show/<?php echo (int)$item['product_id']; ?>" class="btn btn-sm btn-glass px-2.5 py-1.5 fs-7 d-flex align-items-center gap-1">
                                                <i class="ph ph-eye"></i> Xem sản phẩm
                                            </a>
                                        <?php else: ?>
                                            <span class="small text-muted"><i class="ph ph-warning-circle"></i> Thiết bị này đã dừng kinh doanh</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Receipt Summary -->
            <div class="d-flex justify-content-end">
                <div style="width: 280px;">
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Giá trị thiết bị</span>
                        <span class="text-white"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-white border-opacity-5 small text-muted">
                        <span>Cước giao hàng</span>
                        <span class="text-success">Miễn phí</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <span class="fw-bold text-white mb-0">Tổng thanh toán</span>
                        <span class="fs-4 fw-bold text-primary mb-0"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>