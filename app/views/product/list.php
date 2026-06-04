<?php $title = 'Danh sách sản phẩm'; ?>
<?php $products = $products ?? []; ?>
<?php $current_category = $current_category ?? null; ?>
<?php $cartCount = $cartCount ?? 0; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-boxes"></i>
            <span>Product catalog</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Danh sách sản phẩm</h1>
        <p class="lead mb-0">Theo dõi nhanh tồn kho hiển thị, danh mục và giá trong một màn hình trực quan.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-warning text-dark fw-semibold shadow-sm position-relative" style="z-index:1;" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer">
            <i class="fas fa-cart-shopping me-2"></i>Giỏ hàng <?php if ($cartCount > 0): ?><span class="badge bg-dark ms-2"><?php echo $cartCount; ?></span><?php endif; ?>
        </button>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/phamgiahuy/product/add" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="surface-card p-3 h-100">
            <div class="small text-uppercase fw-semibold muted-note mb-2">Tổng sản phẩm</div>
            <div class="d-flex align-items-end justify-content-between">
                <div class="h2 mb-0 fw-bold"><?php echo count($products); ?></div>
                <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25">Đang hiển thị</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="surface-card p-3 h-100">
            <div class="small text-uppercase fw-semibold muted-note mb-2">Danh mục đang xem</div>
            <div class="fw-semibold fs-5 text-truncate"><?php echo htmlspecialchars($current_category->name ?? 'Tất cả danh mục'); ?></div>
            <div class="muted-note mt-1">Lọc theo danh mục từ thanh bên trái</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="surface-card p-3 h-100">
            <div class="small text-uppercase fw-semibold muted-note mb-2">Thao tác nhanh</div>
            <div class="d-flex gap-2 flex-wrap">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/phamgiahuy/product/add" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Thêm mới</a>
                <?php endif; ?>
                <a href="/phamgiahuy/product" class="btn btn-outline-secondary btn-sm"><i class="fas fa-rotate-right me-1"></i>Làm mới</a>
            </div>
        </div>
    </div>
</div>

<div class="surface-card p-3 p-lg-4">
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 84px; height: 84px;">
                <i class="fas fa-box-open fa-2x text-primary"></i>
            </div>
            <h4 class="fw-semibold mb-2">Chưa có sản phẩm nào</h4>
            <p class="mb-4">Hãy tạo sản phẩm đầu tiên để bắt đầu quản lý dữ liệu tập trung.</p>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/phamgiahuy/product/add" class="btn btn-primary">Thêm sản phẩm đầu tiên</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <style>
            .product-grid .card-img-top { width: 100%; height: 160px; object-fit: cover; border-radius: 12px; }
            .product-card-title { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .product-card .card-body { padding: 0.65rem; }
            .product-card .card-footer { background: transparent; border-top: none; padding: 0.5rem 0.65rem; }
        </style>
        <div class="product-grid">
            <div class="row g-3">
                <?php foreach ($products as $product): ?>
                    <div class="col-6 col-md-4 col-lg-4">
                        <div class="surface-card product-card h-100 d-flex flex-column">
                            <div class="p-2">
                                <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                    <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="card-img-top rounded-3">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-3" style="width:100%; height:160px;">
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-1 product-card-title fw-semibold">
                                    <a href="/phamgiahuy/product/show/<?php echo $product->id; ?>" class="text-decoration-none text-reset">
                                        <?php echo htmlspecialchars($product->name); ?>
                                    </a>
                                </div>
                                <div class="small text-muted mb-2" style="flex:1 1 auto;"><?php echo htmlspecialchars(mb_strimwidth($product->description, 0, 80, '...')); ?></div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-primary"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</div>
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="/phamgiahuy/product/addToCart" method="POST" class="m-0">
                                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="redirect_to" value="/phamgiahuy/product">
                                            <button type="submit" class="btn btn-sm btn-primary" title="Thêm vào giỏ">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                        <a href="/phamgiahuy/product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-glass" title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/layout/footer.php'; ?>
