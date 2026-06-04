<?php $title = 'Lịch sử đơn hàng • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Orders Page -->
<style>
    .orders-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
</style>

<!-- Orders Hero Header -->
<div class="orders-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-receipt text-primary"></i>
            <span>Đơn hàng đã đặt</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Lịch Sử Đơn Hàng</h1>
        <p class="text-muted mb-0">Theo dõi trạng thái xử lý và giao nhận của các đơn hàng trước đây.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-light d-flex align-items-center gap-2">
        <i class="ph ph-storefront"></i> Tiếp tục mua sắm
    </a>
</div>

<?php if (empty($orders)): ?>
    <div class="surface-card p-5 text-center">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 80px; height: 80px;">
            <i class="ph ph-package fa-2x text-primary"></i>
        </div>
        <h3 class="fw-bold text-white mb-2">Bạn chưa có đơn hàng nào</h3>
        <p class="text-muted mb-4">Hãy lựa chọn những sản phẩm ưng ý và tiến hành thanh toán.</p>
        <a href="/phamgiahuy/product" class="btn btn-primary px-4 py-2.5 rounded-3">
            Đi đến cửa hàng
        </a>
    </div>
<?php else: ?>
    <div class="surface-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 15%">Mã Đơn</th>
                        <th style="width: 20%">Ngày đặt</th>
                        <th style="width: 25%">Người nhận</th>
                        <th style="width: 15%">Tổng tiền</th>
                        <th style="width: 15%">Trạng thái</th>
                        <th style="width: 10%" class="text-end">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <span class="badge bg-dark bg-opacity-30 text-white border border-white border-opacity-10 px-2.5 py-1.5 font-monospace">
                                    #<?php echo htmlspecialchars($order['id']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-white"><?php echo date('d/m/Y', strtotime($order['date'])); ?></div>
                                <div class="small text-muted"><?php echo date('H:i:s', strtotime($order['date'])); ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-white"><?php echo htmlspecialchars($order['customer']['name']); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($order['customer']['phone']); ?></div>
                            </td>
                            <td>
                                <span class="fw-bold text-primary"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                            </td>
                            <td>
                                <?php
                                $status = $order['status'] ?? 'pending';
                                if ($status === 'pending') {
                                    echo '<span class="badge bg-warning text-dark border border-warning shadow-sm"><i class="ph ph-clock me-1"></i>Chờ xử lý</span>';
                                } elseif ($status === 'processing') {
                                    echo '<span class="badge bg-info text-dark border border-info shadow-sm"><i class="ph ph-spinner-gap spin me-1"></i>Đang xử lý</span>';
                                } elseif ($status === 'shipping') {
                                    echo '<span class="badge bg-primary text-white border border-primary shadow-sm"><i class="ph ph-truck me-1"></i>Đang giao</span>';
                                } elseif ($status === 'completed') {
                                    echo '<span class="badge bg-success text-white border border-success shadow-sm"><i class="ph ph-check-circle me-1"></i>Đã giao</span>';
                                } elseif ($status === 'cancelled') {
                                    echo '<span class="badge bg-danger text-white border border-danger shadow-sm"><i class="ph ph-x-circle me-1"></i>Đã hủy</span>';
                                } else {
                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>';
                                }
                                ?>
                            </td>
                            <td class="text-end">
                                <a href="/phamgiahuy/product/orderDetail/<?php echo urlencode($order['id']); ?>" class="btn btn-sm btn-glass px-3 py-1.5" title="Xem chi tiết">
                                    <i class="ph ph-eye me-1"></i> Xem
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php include 'app/views/layout/footer.php'; ?>