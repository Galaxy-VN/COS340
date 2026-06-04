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
    <a href="/phamgiahuy/product/cart" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-arrow-left me-2"></i>Trở lại giỏ hàng
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="surface-card p-3 p-lg-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="badge bg-primary-subtle text-primary">Bước 1/2</div>
                <h5 class="mb-0 fw-bold">Thông tin giao hàng</h5>
            </div>

            <form id="checkoutForm" action="/phamgiahuy/product/processCheckout" method="POST">
                <div id="step1">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label fw-bold small">Họ và Tên *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="phone" class="form-label fw-bold small">Số điện thoại *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="0912345678" required>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label fw-bold small">Địa chỉ giao hàng *</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Số nhà, đường, phường, quận, tỉnh" required></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="small text-muted"><i class="fas fa-shield-halved text-success me-1"></i>Phương thức: <b>COD</b></div>
                        <div>
                            <button type="button" id="toStep2" class="btn btn-primary">Tiếp tục</button>
                        </div>
                    </div>
                </div>

                <div id="step2" style="display:none;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="badge bg-primary-subtle text-primary">Bước 2/2</div>
                        <h5 class="mb-0 fw-bold">Xác nhận & Thanh toán</h5>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted">Người nhận</div>
                        <div id="reviewName" class="fw-semibold"></div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-muted">Số điện thoại</div>
                        <div id="reviewPhone" class="fw-semibold"></div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-muted">Địa chỉ</div>
                        <div id="reviewAddress" class="fw-semibold"></div>
                    </div>

                    <hr class="my-3">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính</span>
                        <span class="fw-semibold"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Phí vận chuyển</span>
                        <span class="fw-semibold">Miễn phí</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h5 fw-bold mb-0">Tổng</span>
                        <span class="h4 fw-bold text-primary mb-0"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" id="backToStep1" class="btn btn-outline-secondary">Quay lại</button>
                        <button type="submit" class="btn btn-primary flex-grow-1">Xác nhận đặt hàng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="surface-card p-3 p-lg-4 position-sticky" style="top: 1rem;">
            <h6 class="fw-bold mb-3">Tóm tắt đơn hàng (<?php echo count($items); ?>)</h6>
            <div class="order-items-scroll mb-3" style="max-height: 300px; overflow-y: auto;">
                <?php foreach ($items as $item): ?>
                    <div class="d-flex gap-3 mb-3 align-items-center">
                        <div style="width:56px; height:56px; flex-shrink:0;">
                            <?php if (!empty($item['image'])): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($item['image']); ?>" class="img-thumbnail" style="width:56px; height:56px; object-fit:cover; border-radius:10px;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-2" style="width:56px; height:56px;"><i class="fas fa-image text-muted"></i></div>
                            <?php endif; ?>
                        </div>
                        <div style="flex:1 1 auto; min-width:0;">
                            <div class="fw-semibold text-truncate"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="small text-muted">x<?php echo $item['quantity']; ?></div>
                        </div>
                        <div class="fw-semibold text-end"><?php echo number_format($item['line_total'], 0, ',', '.'); ?>đ</div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="border-top pt-3">
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Tạm tính</span><span class="fw-semibold"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span></div>
                <div class="d-flex justify-content-between mb-3"><span class="text-muted">Phí vận chuyển</span><span class="fw-semibold">Miễn phí</span></div>
                <div class="d-flex justify-content-between align-items-center"><span class="h5 fw-bold">Tổng</span><span class="h4 fw-bold text-primary"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span></div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const toStep2 = document.getElementById('toStep2');
    const backToStep1 = document.getElementById('backToStep1');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const form = document.getElementById('checkoutForm');

    function showStep2(){
        // basic validation
        const name = form.name.value.trim();
        const phone = form.phone.value.trim();
        const address = form.address.value.trim();
        if (!name || !phone || !address) {
            alert('Vui lòng điền đầy đủ thông tin giao hàng.');
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