<?php $title = 'Thanh toán đơn hàng • COS340 Store'; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Checkout Page -->
<style>
    .checkout-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .checkout-step-badge {
        font-size: 0.75rem;
        background: rgba(59, 130, 246, 0.15);
        color: var(--brand-300);
        border: 1px solid rgba(59, 130, 246, 0.2);
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
    }
    .checkout-item-thumb {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .checkout-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .step-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.05);
        margin: 1.5rem 0;
    }
    .review-info-box {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: var(--radius-md);
        padding: 1rem;
    }
</style>

<!-- Checkout Hero Header -->
<div class="checkout-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-credit-card text-primary"></i>
            <span>Thanh toán</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Thanh Toán Đơn Hàng</h1>
        <p class="text-muted mb-0">Cung cấp thông tin nhận nhận thiết bị để hoàn tất thủ tục.</p>
    </div>
    <a href="/phamgiahuy/product/cart" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-arrow-left"></i> Trở lại giỏ hàng
    </a>
</div>

<div class="row g-4">
    <!-- Left Column: Checkout steps -->
    <div class="col-lg-8">
        <div class="surface-card p-4">
            <form id="checkoutForm" action="/phamgiahuy/product/processCheckout" method="POST">
                <!-- Step 1: Info -->
                <div id="step1">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="checkout-step-badge">Bước 1/2</span>
                        <h2 class="h5 fw-bold text-white mb-0">Thông tin nhận hàng</h2>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Họ và tên *</label>
                            <input type="text" class="form-control py-2.5" id="name" name="name" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Số điện thoại *</label>
                            <input type="tel" class="form-control py-2.5" id="phone" name="phone" placeholder="0912345678" required>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Địa chỉ giao hàng *</label>
                            <textarea class="form-control py-2.5" id="address" name="address" rows="3" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-white border-opacity-5">
                        <div class="small text-muted"><i class="ph ph-shield-check text-success me-1"></i>Thanh toán: <b>COD (Nhận hàng thu tiền)</b></div>
                        <button type="button" id="toStep2" class="btn btn-primary px-4 py-2.5 rounded-3 fw-semibold">Tiếp tục</button>
                    </div>
                </div>

                <!-- Step 2: Confirmation -->
                <div id="step2" style="display:none;">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="checkout-step-badge">Bước 2/2</span>
                        <h2 class="h5 fw-bold text-white mb-0">Xác nhận thông tin & Đặt hàng</h2>
                    </div>

                    <div class="review-info-box mb-4">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="small text-muted mb-1">Người nhận</div>
                                <div id="reviewName" class="fw-semibold text-white"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="small text-muted mb-1">Số điện thoại</div>
                                <div id="reviewPhone" class="fw-semibold text-white"></div>
                            </div>
                            <div class="col-12">
                                <div class="small text-muted mb-1">Địa chỉ giao hàng</div>
                                <div id="reviewAddress" class="fw-semibold text-white"></div>
                            </div>
                        </div>
                    </div>

                    <div class="step-divider"></div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính</span>
                        <span class="text-white"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Phí giao hàng</span>
                        <span class="text-success fw-medium">Miễn phí</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 pt-2 border-top border-white border-opacity-5">
                        <span class="h6 fw-bold text-white mb-0">Tổng thanh toán</span>
                        <span class="h4 fw-bold text-primary mb-0"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" id="backToStep1" class="btn btn-glass px-4 py-2.5">Quay lại</button>
                        <button type="submit" class="btn btn-primary flex-grow-1 py-2.5 rounded-3 fw-semibold">Xác nhận đặt hàng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Order items summary -->
    <div class="col-lg-4">
        <div class="surface-card p-4 position-sticky" style="top: 1.5rem;">
            <h2 class="h6 fw-bold text-white mb-4">Danh sách đặt hàng (<?php echo count($items); ?>)</h2>
            <div class="order-items-scroll mb-3 pe-1" style="max-height: 320px; overflow-y: auto;">
                <?php foreach ($items as $item): ?>
                    <div class="d-flex gap-3 mb-3 align-items-center">
                        <div class="checkout-item-thumb">
                            <?php if (!empty($item['image']) && file_exists('uploads/' . $item['image'])): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center">
                                    <i class="ph ph-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-semibold text-white text-truncate"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="small text-muted">Số lượng: x<?php echo $item['quantity']; ?></div>
                        </div>
                        <div class="fw-bold text-white text-end"><?php echo number_format($item['line_total'], 0, ',', '.'); ?>đ</div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="border-top border-white border-opacity-5 pt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Cước tạm tính</span>
                    <span class="text-white small"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Vận chuyển</span>
                    <span class="text-success small">Miễn phí</span>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-5">
                    <span class="fw-bold text-white">Tổng cộng</span>
                    <span class="h5 fw-bold text-primary mb-0"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>

<!-- Checkout step navigation logic -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    const toStep2 = document.getElementById('toStep2');
    const backToStep1 = document.getElementById('backToStep1');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const form = document.getElementById('checkoutForm');

    function showStep2(){
        const name = form.name.value.trim();
        const phone = form.phone.value.trim();
        const address = form.address.value.trim();
        if (!name || !phone || !address) {
            alert('Vui lòng điền đầy đủ thông tin giao nhận hàng.');
            return;
        }
        document.getElementById('reviewName').textContent = name;
        document.getElementById('reviewPhone').textContent = phone;
        document.getElementById('reviewAddress').textContent = address.replace(/\n/g, ', ');
        step1.style.display = 'none';
        step2.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function showStep1(){
        step2.style.display = 'none';
        step1.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    if (toStep2) toStep2.addEventListener('click', showStep2);
    if (backToStep1) backToStep1.addEventListener('click', showStep1);
});
</script>