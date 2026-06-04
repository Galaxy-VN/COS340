<?php $title = 'Quản lý đơn hàng'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-tasks"></i>
            <span>Order Dashboard</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Quản lý đơn hàng</h1>
        <p class="lead mb-0">Xem danh sách, kiểm tra thông tin và cập nhật trạng thái đơn hàng của hệ thống.</p>
    </div>
    <a href="/phamgiahuy/Product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index: 1;">
        <i class="fas fa-arrow-left me-2"></i>Quay lại cửa hàng
    </a>
</div>

<?php if (empty($orders)): ?>
    <div class="surface-card p-5 text-center mt-4">
        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 100px; height: 100px;">
            <i class="fas fa-box-open fa-3x text-primary"></i>
        </div>
        <h3 class="fw-bold mb-2">Chưa có đơn hàng nào</h3>
        <p class="text-muted mb-0">Hệ thống chưa ghi nhận bất kỳ giao dịch mua hàng nào.</p>
    </div>
<?php else: ?>
    <div class="surface-card p-3 p-lg-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 10%">Mã Đơn</th>
                        <th style="width: 15%">Ngày đặt</th>
                        <th style="width: 25%">Khách hàng</th>
                        <th style="width: 15%">Tổng tiền</th>
                        <th style="width: 20%">Trạng thái</th>
                        <th style="width: 15%">Thao tác</th>
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
                                <div class="small text-muted mb-1"><i class="fas fa-phone fa-xs me-1"></i><?php echo htmlspecialchars($order['customer']['phone']); ?></div>
                                <div class="small text-soft text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($order['customer']['address']); ?>">
                                    <i class="fas fa-location-dot fa-xs me-1"></i><?php echo htmlspecialchars($order['customer']['address']); ?>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-primary fs-6"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                            </td>
                            <td>
                                <form action="/phamgiahuy/Product/updateOrderStatus" method="POST" class="m-0">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-select form-select-sm fw-semibold" onchange="this.form.submit()" style="max-width: 180px; background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.15);">
                                        <option value="pending" class="text-dark" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>⏳ Chờ xử lý</option>
                                        <option value="processing" class="text-dark" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>⚙️ Đang xử lý</option>
                                        <option value="shipping" class="text-dark" <?php echo $order['status'] === 'shipping' ? 'selected' : ''; ?>>🚚 Đang giao hàng</option>
                                        <option value="completed" class="text-dark" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>✅ Đã hoàn thành</option>
                                        <option value="cancelled" class="text-dark" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>❌ Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="/phamgiahuy/Product/orderDetail/<?php echo urlencode($order['id']); ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Chi tiết
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
