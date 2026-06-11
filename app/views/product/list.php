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
                <div class="h2 mb-0 fw-bold" id="productCount"><?php echo count($products); ?></div>
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
                <button id="refreshBtn" class="btn btn-outline-secondary btn-sm"><i class="fas fa-rotate-right me-1"></i>Làm mới</button>
            </div>
        </div>
    </div>
</div>

<div class="surface-card p-3 p-lg-4">
    <div id="loadingState" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Đang tải...</span>
        </div>
        <div class="mt-2 muted-note">Đang tải danh sách sản phẩm...</div>
    </div>

    <div id="emptyState" class="empty-state" style="display:none;">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 84px; height: 84px;">
            <i class="fas fa-box-open fa-2x text-primary"></i>
        </div>
        <h4 class="fw-semibold mb-2">Chưa có sản phẩm nào</h4>
        <p class="mb-4">Hãy tạo sản phẩm đầu tiên để bắt đầu quản lý dữ liệu tập trung.</p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/phamgiahuy/product/add" class="btn btn-primary">Thêm sản phẩm đầu tiên</a>
        <?php endif; ?>
    </div>

    <div id="productGrid" style="display:none;">
        <style>
            .product-grid .card-img-top { width: 100%; height: 160px; object-fit: cover; border-radius: 12px; }
            .product-card-title { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .product-card .card-body { padding: 0.65rem; }
            .product-card .card-footer { background: transparent; border-top: none; padding: 0.5rem 0.65rem; }
        </style>
        <div class="product-grid">
            <div class="row g-3" id="productList"></div>
        </div>
    </div>
</div>

<script>
const API_BASE = '/phamgiahuy/api';
const isAdmin = <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'true' : 'false'; ?>;
const currentCategoryId = <?php echo $current_category->id ?? 'null'; ?>;

async function fetchProducts() {
    const loadingEl = document.getElementById('loadingState');
    const emptyEl = document.getElementById('emptyState');
    const gridEl = document.getElementById('productGrid');
    const listEl = document.getElementById('productList');
    const countEl = document.getElementById('productCount');

    loadingEl.style.display = 'block';
    emptyEl.style.display = 'none';
    gridEl.style.display = 'none';

    try {
        let url = currentCategoryId
            ? `${API_BASE}/product`
            : `${API_BASE}/product`;

        if (currentCategoryId) {
            const resp = await fetch(`${API_BASE}/product`);
            const allProducts = await resp.json();
            var products = allProducts.filter(p => p.category_id == currentCategoryId);
        } else {
            var products = await fetch(`${API_BASE}/product`).then(r => r.json());
        }

        loadingEl.style.display = 'none';

        if (!products || products.length === 0) {
            emptyEl.style.display = 'block';
            countEl.textContent = '0';
            return;
        }

        countEl.textContent = products.length;
        listEl.innerHTML = '';

        products.forEach(product => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-4';
            col.innerHTML = `
                <div class="surface-card product-card h-100 d-flex flex-column">
                    <div class="p-2">
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-3" style="width:100%; height:160px;">
                            <i class="fas fa-image text-muted fa-2x"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="mb-1 product-card-title fw-semibold">
                            <a href="/phamgiahuy/product/show/${product.id}" class="text-decoration-none text-reset">
                                ${escapeHtml(product.name)}
                            </a>
                        </div>
                        <div class="small text-muted mb-2" style="flex:1 1 auto;">${escapeHtml(truncate(product.description, 80))}</div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fw-bold text-primary">${formatPrice(product.price)}đ</div>
                            <div class="d-flex align-items-center gap-2">
                                <form action="/phamgiahuy/product/addToCart" method="POST" class="m-0">
                                    <input type="hidden" name="product_id" value="${product.id}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="redirect_to" value="/phamgiahuy/product">
                                    <button type="submit" class="btn btn-sm btn-primary" title="Thêm vào giỏ">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                                <a href="/phamgiahuy/product/show/${product.id}" class="btn btn-sm btn-glass" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                                ${isAdmin ? `
                                <a href="/phamgiahuy/product/edit/${product.id}" class="btn btn-sm btn-glass" title="Sửa">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-glass delete-btn" title="Xóa" data-id="${product.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            listEl.appendChild(col);
        });

        gridEl.style.display = 'block';

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.dataset.id;
                if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) return;

                try {
                    const resp = await authFetch(`${API_BASE}/product/${id}`, { method: 'DELETE' });
                    if (!resp) return;
                    if (resp.ok) {
                        showToast('success', 'Thành công', 'Sản phẩm đã được xóa.');
                        fetchProducts();
                    } else {
                        showToast('error', 'Lỗi', 'Xóa sản phẩm thất bại.');
                    }
                } catch (e) {
                    alert('Lỗi kết nối.');
                }
            });
        });

    } catch (e) {
        loadingEl.style.display = 'none';
        emptyEl.style.display = 'block';
        console.error('Error fetching products:', e);
    }
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function truncate(text, length) {
    if (!text) return '';
    return text.length > length ? text.substring(0, length) + '...' : text;
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}

document.getElementById('refreshBtn').addEventListener('click', fetchProducts);

document.addEventListener('DOMContentLoaded', fetchProducts);
</script>

<?php include 'app/views/layout/footer.php'; ?>
