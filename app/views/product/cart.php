<?php $title = 'Giỏ hàng • COS340 Store'; ?>
<?php $items = $items ?? []; ?>
<?php $subtotal = $subtotal ?? 0; ?>
<?php $cartCount = $cartCount ?? 0; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Cart Page -->
<style>
    .cart-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .cart-item-row {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    .cart-item-row:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 255, 255, 0.1);
    }
    .cart-img-wrap {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .cart-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<!-- Cart Hero Header -->
<div class="cart-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-shopping-cart text-primary"></i>
            <span>Giỏ hàng cá nhân</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Giỏ Hàng Của Bạn</h1>
        <p class="text-muted mb-0">Xem lại danh sách, điều chỉnh số lượng và hoàn tất đặt hàng.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/phamgiahuy/product" class="btn btn-light d-flex align-items-center gap-2">
            <i class="ph ph-arrow-left"></i> Tiếp tục mua sắm
        </a>
        <?php if (!empty($items)): ?>
            <form action="/phamgiahuy/product/clearCart" method="POST" class="m-0">
                <button type="submit" class="btn btn-glass text-danger d-flex align-items-center gap-2" onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
                    <i class="ph ph-trash"></i> Xóa tất cả
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php if (empty($items)): ?>
    <div class="surface-card p-5 text-center">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 80px; height: 80px;">
            <i class="ph ph-shopping-bag-open fa-2x text-primary"></i>
        </div>
        <h3 class="fw-bold text-white mb-2">Giỏ hàng đang trống</h3>
        <p class="text-muted mb-4">Hãy chọn thêm vài sản phẩm chất lượng để bắt đầu thanh toán.</p>
        <a href="/phamgiahuy/product" class="btn btn-primary px-4 py-2.5 rounded-3">
            <i class="ph ph-storefront me-1"></i> Quay lại cửa hàng
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <!-- Cart Items List -->
        <div class="col-lg-8">
            <div class="surface-card p-4">
                <form action="/phamgiahuy/product/updateCart" method="POST" id="cart-items-form">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h5 fw-bold text-white mb-0"><?php echo count($items); ?> sản phẩm đã chọn</h2>
                        <button type="submit" class="btn btn-glass btn-sm px-3"><i class="ph ph-arrows-counter-clockwise me-1"></i> Cập nhật</button>
                    </div>

                    <div class="cart-items-wrapper">
                        <?php foreach ($items as $item): ?>
                            <div class="cart-item-row d-flex flex-column flex-sm-row align-items-center gap-3">
                                <!-- Image -->
                                <div class="cart-img-wrap">
                                    <?php if (!empty($item['image']) && file_exists('uploads/' . $item['image'])): ?>
                                        <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <?php else: ?>
                                        <div class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center">
                                            <i class="ph ph-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Name and Details -->
                                <div class="flex-grow-1 text-center text-sm-start min-w-0">
                                    <h3 class="h6 fw-bold text-white mb-1 text-truncate"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <div class="small text-muted">Mã thiết bị: #<?php echo $item['id']; ?></div>
                                </div>

                                <!-- Quantity Input -->
                                <div class="px-2" style="width: 130px;">
                                    <label class="small text-muted d-block mb-1 text-center text-sm-start">Số lượng</label>
                                    <input type="number" class="form-control text-center py-1.5" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" step="1">
                                </div>

                                <!-- Prices -->
                                <div class="text-center text-sm-end px-2" style="min-width: 120px;">
                                    <div class="fw-bold text-primary"><?php echo number_format($item['line_total'], 0, ',', '.'); ?>đ</div>
                                    <div class="small text-muted"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ / chiếc</div>
                                </div>

                                <!-- Delete button -->
                                <div class="text-end">
                                    <a href="/phamgiahuy/product/removeFromCart/<?php echo $item['id']; ?>" class="btn btn-glass text-danger px-2.5 py-2" title="Xóa dòng hàng" onclick="return confirm('Xóa sản phẩm này?')">
                                        <i class="ph ph-trash" style="font-size: 1.1rem;"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Panel -->
        <div class="col-lg-4">
            <div class="surface-card p-4 position-sticky" style="top: 1.5rem;">
                <h2 class="h5 fw-bold text-white mb-4">Tóm tắt đơn hàng</h2>

                <div class="field-card mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Tổng số lượng</span>
                    <strong class="text-white"><?php echo $cartCount; ?> thiết bị</strong>
                </div>
                <div class="field-card mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Dòng sản phẩm</span>
                    <strong class="text-white"><?php echo count($items); ?> loại</strong>
                </div>
                <div class="field-card mb-4 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Thành tiền</span>
                    <strong class="fs-5 text-primary"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</strong>
                </div>

                <div class="d-grid gap-2">
                    <a href="/phamgiahuy/product/checkout" class="btn btn-primary py-3 rounded-3 d-flex align-items-center justify-content-center gap-2 fw-semibold">
                        <i class="ph ph-credit-card"></i> Tiến hành thanh toán
                    </a>
                    <a href="/phamgiahuy/product" class="btn btn-glass py-2.5 rounded-3 text-center">
                        Tiếp tục chọn hàng
                    </a>
                </div>
                <div class="text-muted small text-center mt-3">Sử dụng thanh toán qua tài khoản hoặc thanh toán COD khi nhận hàng.</div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'app/views/layout/footer.php'; ?>

<!-- Auto Update Cart JS -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('cart-items-form');
    if (!form) return;
    let timer = null;
    const inputs = form.querySelectorAll('input[name^="quantity"]');
    inputs.forEach(function(input){
        input.addEventListener('input', function(){
            clearTimeout(timer);
            // Auto submit with a short debounce to give time to type
            timer = setTimeout(function(){
                form.submit();
            }, 750);
        });
    });
});
</script>