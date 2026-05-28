<?php $title = 'Giỏ hàng'; ?>
<?php $items = $items ?? []; ?>
<?php $subtotal = $subtotal ?? 0; ?>
<?php $cartCount = $cartCount ?? 0; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-cart-shopping"></i>
            <span>Shopping cart</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Giỏ hàng của bạn</h1>
        <p class="lead mb-0">Theo dõi số lượng, điều chỉnh nhanh và kiểm tra tổng giá trị ngay trên một màn hình.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="/phamgiahuy/Product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
            <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua
        </a>
        <form action="/phamgiahuy/Product/clearCart" method="POST" class="d-inline">
            <button type="submit" class="btn btn-outline-light fw-semibold" onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
                <i class="fas fa-trash-can me-2"></i>Xóa giỏ
            </button>
        </form>
    </div>
</div>

<?php if (empty($items)): ?>
    <div class="surface-card p-4 p-lg-5 text-center">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 88px; height: 88px;">
            <i class="fas fa-basket-shopping fa-2x text-primary"></i>
        </div>
        <h3 class="fw-bold mb-2">Giỏ hàng đang trống</h3>
        <p class="muted-note mb-4">Hãy thêm vài sản phẩm vào giỏ để bắt đầu đặt hàng.</p>
        <a href="/phamgiahuy/Product" class="btn btn-primary">
            <i class="fas fa-box me-2"></i>Đi đến danh sách sản phẩm
        </a>
    </div>
<?php else: ?>
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="surface-card p-3 p-lg-4">
                <form action="/phamgiahuy/Product/updateCart" method="POST">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-wrap">
                        <div>
                            <div class="small text-uppercase fw-semibold muted-note">Sản phẩm trong giỏ</div>
                            <h2 class="h5 fw-bold mb-0"><?php echo count($items); ?> dòng hàng</h2>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-rotate me-2"></i>Cập nhật giỏ hàng
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th style="width: 130px;">Đơn giá</th>
                                    <th style="width: 130px;">Số lượng</th>
                                    <th style="width: 140px;">Thành tiền</th>
                                    <th style="width: 90px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-4 overflow-hidden bg-light d-flex align-items-center justify-content-center" style="width: 76px; height: 76px; flex: 0 0 auto;">
                                                    <?php if (!empty($item['image'])): ?>
                                                        <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="Ảnh sản phẩm" class="w-100 h-100" style="object-fit: cover;">
                                                    <?php else: ?>
                                                        <i class="fas fa-image text-muted"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold"><?php echo htmlspecialchars($item['name']); ?></div>
                                                    <div class="small muted-note">Mã #<?php echo $item['id']; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-primary"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                        <td>
                                            <input type="number" class="form-control" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" step="1">
                                            <div class="small muted-note mt-1">Nhập 0 để xóa</div>
                                        </td>
                                        <td class="fw-bold"><?php echo number_format($item['line_total'], 0, ',', '.'); ?>đ</td>
                                        <td>
                                            <a href="/phamgiahuy/Product/removeFromCart/<?php echo $item['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Xóa sản phẩm này khỏi giỏ?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="surface-card p-3 p-lg-4 position-sticky" style="top: 1rem;">
                <div class="small text-uppercase fw-semibold muted-note mb-2">Tóm tắt đơn hàng</div>
                <h2 class="h4 fw-bold mb-4">Sẵn sàng thanh toán</h2>

                <div class="field-card mb-3 d-flex justify-content-between align-items-center">
                    <span class="muted-note">Số sản phẩm</span>
                    <strong><?php echo $cartCount; ?></strong>
                </div>
                <div class="field-card mb-3 d-flex justify-content-between align-items-center">
                    <span class="muted-note">Số dòng hàng</span>
                    <strong><?php echo count($items); ?></strong>
                </div>
                <div class="field-card mb-4 d-flex justify-content-between align-items-center">
                    <span class="muted-note">Tạm tính</span>
                    <strong class="fs-5 text-primary"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</strong>
                </div>

                <div class="d-grid gap-2">
                    <a href="/phamgiahuy/Product" class="btn btn-outline-secondary">
                        <i class="fas fa-bag-shopping me-2"></i>Tiếp tục chọn hàng
                    </a>
                    <a href="/phamgiahuy/Product/checkout" class="btn btn-primary">
                        <i class="fas fa-credit-card me-2"></i>Thanh toán
                    </a>
                </div>
                <div class="muted-note small mt-3">Nhấn Thanh toán để nhập thông tin nhận hàng và xác nhận đơn của bạn.</div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'app/views/layout/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.querySelector('form[action="/phamgiahuy/Product/updateCart"]');
    if (!form) return;
    let timer = null;
    const inputs = form.querySelectorAll('input[name^="quantity"]');
    inputs.forEach(function(input){
        input.addEventListener('input', function(){
            clearTimeout(timer);
            // debounce so user can type a number
            timer = setTimeout(function(){
                form.submit();
            }, 600);
        });
    });
});
</script>