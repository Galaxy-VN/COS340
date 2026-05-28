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
        <a href="/phamgiahuy/Product/cart" class="btn btn-warning text-dark fw-semibold shadow-sm position-relative" style="z-index:1;">
            <i class="fas fa-cart-shopping me-2"></i>Giỏ hàng <?php if ($cartCount > 0): ?><span class="badge bg-dark ms-2"><?php echo $cartCount; ?></span><?php endif; ?>
        </a>
        <a href="/phamgiahuy/Product/add" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
            <i class="fas fa-plus me-2"></i>Thêm sản phẩm
        </a>
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
                <a href="/phamgiahuy/Product/add" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Thêm mới</a>
                <a href="/phamgiahuy/Product" class="btn btn-outline-secondary btn-sm"><i class="fas fa-rotate-right me-1"></i>Làm mới</a>
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
            <a href="/phamgiahuy/Product/add" class="btn btn-primary">Thêm sản phẩm đầu tiên</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table id="productTable" class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 84px;">Ảnh</th>
                        <th style="width: 70px;">#</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th style="width: 140px;">Giá</th>
                        <th style="width: 150px;">Danh mục</th>
                        <th style="width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                    <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="Ảnh" class="img-thumbnail" width="64" height="64">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; border-radius: 14px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-secondary"><?php echo $product->id; ?></span></td>
                            <td>
                                <div class="fw-semibold"><?php echo htmlspecialchars($product->name); ?></div>
                                <div class="small muted-note">Mã SP: #<?php echo $product->id; ?></div>
                            </td>
                            <td class="text-muted" style="max-width: 360px;"><?php echo htmlspecialchars($product->description); ?></td>
                            <td><span class="fw-semibold text-primary"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span></td>
                            <td><span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25"><?php echo htmlspecialchars($product->category_name ?? '—'); ?></span></td>
                            <td>
                                <div class="btn-group btn-group-sm flex-wrap">
                                    <form action="/phamgiahuy/Product/addToCart" method="POST" class="d-inline">
                                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="redirect_to" value="/phamgiahuy/Product">
                                        <button type="submit" class="btn btn-outline-success" title="Thêm vào giỏ">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                    <a href="/phamgiahuy/Product/show/<?php echo $product->id; ?>" class="btn btn-outline-primary" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/phamgiahuy/Product/edit/<?php echo $product->id; ?>" class="btn btn-outline-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/phamgiahuy/Product/delete/<?php echo $product->id; ?>" class="btn btn-outline-danger" onclick="return confirm('Xóa sản phẩm này?')" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/layout/footer.php'; ?>
