<?php $title = 'Danh sách đơn hàng'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-list-check"></i>
            <span>Order history</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Lịch sử đơn hàng</h1>
        <p class="lead mb-0">Theo dõi trạng thái và chi tiết các đơn hàng bạn đã mua trước đây.</p>
    </div>
    <a href="/phamgiahuy/Product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index: 1;">
        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua hàng
    </a>
</div>

<?php if (empty($orders)): ?>
    <div class="surface-card p-5 text-center mt-4">
        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 100px; height: 100px;">
            <i class="fas fa-box-open fa-3x text-primary"></i>
        </div>
        <h3 class="fw-bold mb-2">Bạn chưa có đơn hàng nào</h3>
        <p class="text-muted mb-4 text-center">Hãy thêm các sản phẩm yêu thích vào giỏ hàng và thanh toán nhé.</p>
        <a href="/phamgiahuy/Product" class="btn btn-primary btn-lg rounded-pill px-5">
            <i class="fas fa-shop me-2"></i>Đi đến cửa hàng
        </a>
    </div>
<?php else: ?>
    <div class="surface-card p-3 p-lg-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 15%">Mã Đơn</th>
                        <th style="width: 20%">Ngày đặt</th>
                        <th style="width: 25%">Người nhận</th>
                        <th style="width: 15%">Tổng tiền</th>
                        <th style="width: 15%">Trạng thái</th>
                        <th style="width: 10%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <span class="badge bg-dark bg-opacity-10 text-main border px-2 py-1 fs-6">
                                    <i class="fas fa-hashtag me-1 text-muted"></i><?php echo htmlspecialchars($order['id']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold"><?php echo date('d/m/Y', strtotime($order['date'])); ?></div>
                                <div class="small text-muted"><?php echo date('H:i:s', strtotime($order['date'])); ?></div>
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo htmlspecialchars($order['customer']['name']); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($order['customer']['phone']); ?></div>
                            </td>
                            <td>
                                <span class="fw-bold text-primary fs-6"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                            </td>
                            <td>
                                <?php
                                $status = $order['status'] ?? 'pending';
                                if ($status === 'pending') {
                                    echo '<span class="badge bg-warning text-dark border border-warning shadow-sm"><i class="fas fa-clock me-1"></i>Chờ xử lý</span>';
                                } elseif ($status === 'processing') {
                                    echo '<span class="badge bg-info text-dark border border-info shadow-sm"><i class="fas fa-spinner fa-spin me-1"></i>Đang xử lý</span>';
                                } elseif ($status === 'shipping') {
                                    echo '<span class="badge bg-primary text-white border border-primary shadow-sm"><i class="fas fa-truck me-1"></i>Đang giao</span>';
                                } elseif ($status === 'completed') {
                                    echo '<span class="badge bg-success text-white border border-success shadow-sm"><i class="fas fa-circle-check me-1"></i>Đã hoàn thành</span>';
                                } elseif ($status === 'cancelled') {
                                    echo '<span class="badge bg-danger text-white border border-danger shadow-sm"><i class="fas fa-circle-xmark me-1"></i>Đã hủy</span>';
                                } else {
                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="/phamgiahuy/Product/orderDetail/<?php echo urlencode($order['id']); ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Xem
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