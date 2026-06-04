<?php $title = 'Quản lý đơn hàng • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Manage Orders Page -->
<style>
    .admin-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
</style>

<!-- Admin Hero Header -->
<div class="admin-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-gear text-primary"></i>
            <span>Bảng điều khiển Admin</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Quản Lý Đơn Hàng</h1>
        <p class="text-muted mb-0">Theo dõi, kiểm tra thông tin giao nhận và chuyển đổi trạng thái đơn hàng của hệ thống.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-storefront"></i> Quay lại cửa hàng
    </a>
</div>

<?php if (empty($orders)): ?>
    <div class="surface-card p-5 text-center">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 80px; height: 80px;">
            <i class="ph ph-list-bullets fa-2x text-primary"></i>
        </div>
        <h3 class="fw-bold text-white mb-2">Chưa có đơn hàng nào</h3>
        <p class="text-muted mb-0">Hệ thống chưa ghi nhận bất kỳ giao dịch mua hàng nào.</p>
    </div>
<?php else: ?>
    <div class="surface-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 8%">Mã Đơn</th>
                        <th style="width: 12%">Ngày đặt</th>
                        <th style="width: 15%">Tài khoản</th>
                        <th style="width: 18%">Người nhận</th>
                        <th style="width: 20%">Địa chỉ giao</th>
                        <th style="width: 12%">Tổng tiền</th>
                        <th style="width: 15%">Trạng thái</th>
                        <th style="width: 10%" class="text-end">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <span class="badge bg-dark bg-opacity-30 text-white border border-white border-opacity-10 px-2 py-1.5 font-monospace">
                                    #<?php echo htmlspecialchars($order['id']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-white"><?php echo date('d/m/Y', strtotime($order['date'])); ?></div>
                                <div class="small text-muted"><?php echo date('H:i:s', strtotime($order['date'])); ?></div>
                            </td>
                            <td>
                                <?php if (!empty($order['username'])): ?>
                                    <span class="d-inline-flex align-items-center gap-2">
                                        <?php if (!empty($order['avatar']) && file_exists('uploads/' . $order['avatar'])): ?>
                                            <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($order['avatar']); ?>" class="rounded-circle" style="width: 24px; height: 24px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 0.7rem;">
                                                <?php echo strtoupper(substr($order['username'], 0, 2)); ?>
                                            </div>
                                        <?php endif; ?>
                                        <span class="fw-semibold text-white-50 small"><?php echo htmlspecialchars($order['username']); ?></span>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-10 text-muted border border-white border-opacity-5"><i class="ph ph-eye-slash me-1"></i>Vãng lai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-white"><?php echo htmlspecialchars($order['customer']['name']); ?></div>
                                <div class="small text-muted"><i class="ph ph-phone fa-xs me-1"></i><?php echo htmlspecialchars($order['customer']['phone']); ?></div>
                            </td>
                            <td>
                                <div class="small text-muted text-truncate" style="max-width: 180px;" title="<?php echo htmlspecialchars($order['customer']['address']); ?>">
                                    <i class="ph ph-map-pin fa-xs me-1"></i><?php echo htmlspecialchars($order['customer']['address']); ?>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-primary"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                            </td>
                            <td>
                                <form action="/phamgiahuy/product/updateOrderStatus" method="POST" class="m-0">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-select form-select-sm fw-semibold py-1.5" onchange="this.form.submit()" style="max-width: 160px; background-color: rgba(15, 23, 42, 0.4); border-color: rgba(255,255,255,0.12); color: var(--text-main);">
                                        <option value="pending" class="text-dark bg-white" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>⏳ Chờ xử lý</option>
                                        <option value="processing" class="text-dark bg-white" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>⚙️ Đang xử lý</option>
                                        <option value="shipping" class="text-dark bg-white" <?php echo $order['status'] === 'shipping' ? 'selected' : ''; ?>>🚚 Đang giao</option>
                                        <option value="completed" class="text-dark bg-white" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>✅ Đã hoàn thành</option>
                                        <option value="cancelled" class="text-dark bg-white" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>❌ Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-end">
                                <a href="/phamgiahuy/product/orderDetail/<?php echo urlencode($order['id']); ?>" class="btn btn-sm btn-glass px-2.5 py-1.5">
                                    <i class="ph ph-eye me-1"></i> Chi tiết
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
