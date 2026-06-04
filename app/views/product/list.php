<?php $title = 'Cửa hàng • COS340 Store'; ?>
<?php $products = $products ?? []; ?>
<?php $current_category = $current_category ?? null; ?>
<?php $cartCount = $cartCount ?? 0; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Catalog Page -->
<style>
    .catalog-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .catalog-hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -30px;
        width: 180px;
        height: 180px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.3), transparent 70%);
        pointer-events: none;
    }
    .filter-badge-active {
        background: var(--brand-500) !important;
        color: white !important;
        box-shadow: 0 0 12px rgba(59, 130, 246, 0.4);
    }
    .catalog-grid .product-card-premium {
        background: var(--paper);
        border: var(--glass-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }
    .catalog-grid .product-card-premium:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-float), var(--liquid-highlight), 0 0 20px rgba(59, 130, 246, 0.12);
        border-color: rgba(59, 130, 246, 0.25);
    }
    .catalog-grid .product-image-container {
        padding-top: 85%;
        position: relative;
        background: rgba(255, 255, 255, 0.01);
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }
    .catalog-grid .product-image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .catalog-grid .product-card-premium:hover .product-image-container img {
        transform: scale(1.05);
    }
</style>

<!-- Catalog Header / Hero -->
<div class="catalog-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-squares-four text-primary"></i>
            <span>Cửa hàng công nghệ</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Danh Sách Sản Phẩm</h1>
        <p class="text-muted mb-0">Theo dõi thông tin thiết bị, giá bán và cấu hình trực quan thời gian thực.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <button class="btn btn-warning text-dark fw-semibold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer">
            <i class="ph ph-shopping-cart"></i> Giỏ hàng 
            <?php if ($cartCount > 0): ?>
                <span class="badge bg-dark text-white rounded-pill px-2"><?php echo $cartCount; ?></span>
            <?php endif; ?>
        </button>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/phamgiahuy/product/add" class="btn btn-primary fw-semibold d-flex align-items-center gap-2">
                <i class="ph ph-plus"></i> Thêm sản phẩm
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="surface-card p-3 h-100 d-flex flex-column justify-content-between">
            <div class="small text-uppercase tracking-wider text-muted fw-semibold mb-2">Tổng sản phẩm</div>
            <div class="d-flex align-items-end justify-content-between mt-auto">
                <div class="h3 mb-0 fw-bold"><?php echo count($products); ?></div>
                <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10">Đang hiển thị</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="surface-card p-3 h-100 d-flex flex-column justify-content-between">
            <div class="small text-uppercase tracking-wider text-muted fw-semibold mb-2">Danh mục đang xem</div>
            <div class="fw-bold fs-5 text-truncate text-white mt-auto"><?php echo htmlspecialchars($current_category->name ?? 'Tất cả sản phẩm'); ?></div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="surface-card p-3 h-100 d-flex flex-column justify-content-between">
            <div class="small text-uppercase tracking-wider text-muted fw-semibold mb-2">Thao tác nhanh</div>
            <div class="d-flex gap-2 mt-auto">
                <a href="/phamgiahuy/product" class="btn btn-glass btn-sm flex-grow-1 py-2"><i class="ph ph-arrows-counter-clockwise me-1"></i> Làm mới</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/phamgiahuy/category" class="btn btn-glass btn-sm flex-grow-1 py-2"><i class="ph ph-folder me-1"></i> Quản lý DM</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Catalog Layout -->
<div class="catalog-grid">
    <?php if (empty($products)): ?>
        <div class="surface-card p-5 text-center">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 80px; height: 80px;">
                <i class="ph ph-cube-transparent fa-2x text-primary"></i>
            </div>
            <h4 class="fw-bold text-white mb-2">Chưa có sản phẩm nào</h4>
            <p class="text-muted mb-4">Danh mục này hiện chưa có sản phẩm. Vui lòng quay lại sau.</p>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/phamgiahuy/product/add" class="btn btn-primary px-4 py-2 rounded-3">Thêm sản phẩm mới</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($products as $product): ?>
                <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                    <div class="product-card-premium h-100 d-flex flex-column">
                        <div class="product-image-container">
                            <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark" style="position:absolute;">
                                    <i class="ph ph-image-square text-muted" style="font-size: 2.5rem;"></i>
                                </div>
                            <?php endif; ?>
                            <a href="/phamgiahuy/product/show/<?php echo $product->id; ?>" class="product-overlay-btn" title="Xem chi tiết">
                                <i class="ph ph-eye" style="font-size: 1.2rem;"></i>
                            </a>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10 align-self-start mb-2"><?php echo htmlspecialchars($product->category_name ?? 'Thiết bị'); ?></span>
                            <h3 class="h6 fw-bold text-white text-truncate mb-2" title="<?php echo htmlspecialchars($product->name); ?>">
                                <a href="/phamgiahuy/product/show/<?php echo $product->id; ?>" class="text-decoration-none text-reset hover-accent">
                                    <?php echo htmlspecialchars($product->name); ?>
                                </a>
                            </h3>
                            <p class="small text-muted flex-grow-1 mb-3">
                                <?php echo htmlspecialchars(mb_strimwidth($product->description, 0, 70, '...')); ?>
                            </p>
                            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-white border-opacity-5">
                                <div class="fw-bold text-primary"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</div>
                                <div class="d-flex gap-1">
                                    <form action="/phamgiahuy/product/addToCart" method="POST" class="m-0">
                                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="redirect_to" value="/phamgiahuy/product">
                                        <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center px-2 py-1" style="height:32px; width:32px;" title="Thêm vào giỏ">
                                            <i class="ph ph-shopping-cart-simple" style="font-size: 1.1rem;"></i>
                                        </button>
                                    </form>
                                    <a href="/phamgiahuy/product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-glass d-flex align-items-center justify-content-center px-2 py-1" style="height:32px; width:32px;" title="Xem">
                                        <i class="ph ph-eye" style="font-size: 1.1rem;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/layout/footer.php'; ?>
