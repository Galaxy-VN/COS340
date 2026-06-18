<?php $title = 'Chỉnh sửa sản phẩm'; ?>
<?php $product = $product ?? (object) ['id' => '', 'name' => '', 'description' => '', 'category_id' => '', 'price' => '']; ?>
<?php $categories = $categories ?? []; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-pen-to-square"></i>
            <span>Edit item</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Chỉnh sửa sản phẩm</h1>
        <p class="lead mb-0">Điều chỉnh thông tin sản phẩm và cập nhật theo từng lần chỉnh sửa.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="surface-card p-3 p-lg-4">
            <div id="errorAlert" class="alert alert-danger border-0 rounded-4" style="display:none;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul id="errorList" class="mb-0 ps-3"></ul>
            </div>

            <form id="productForm">
                <input type="hidden" name="id" id="productId" value="<?php echo $product->id; ?>">

                <div class="field-card mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="fw-semibold">Đang chỉnh sửa: #<?php echo $product->id; ?></div>
                            <div class="muted-note">Thông tin thay đổi sẽ cập nhật ngay sau khi nhấn Cập nhật.</div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25">Edit mode</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold">Tên *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product->name); ?>" required>
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($product->description); ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">Danh mục *</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $product->category_id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">Giá *</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product->price); ?>" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-warning" id="submitBtn">
                        <i class="fas fa-save me-1"></i>Cập nhật
                    </button>
                    <a href="/phamgiahuy/product" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const API_BASE = '/phamgiahuy/api';
const productId = document.getElementById('productId').value;

document.getElementById('productForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const errorAlert = document.getElementById('errorAlert');
    const errorList = document.getElementById('errorList');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang cập nhật...';
    errorAlert.style.display = 'none';

    const data = {
        name: document.getElementById('name').value.trim(),
        description: document.getElementById('description').value.trim(),
        price: parseFloat(document.getElementById('price').value) || 0,
        category_id: parseInt(document.getElementById('category_id').value) || 0
    };

    try {
        const resp = await fetch(`${API_BASE}/product/${productId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await resp.json();

        if (resp.ok) {
            window.location.href = '/phamgiahuy/product';
        } else {
            errorList.innerHTML = '';
            if (result.errors) {
                result.errors.forEach(err => {
                    const li = document.createElement('li');
                    li.textContent = err;
                    errorList.appendChild(li);
                });
            } else if (result.error) {
                const li = document.createElement('li');
                li.textContent = result.error;
                errorList.appendChild(li);
            }
            errorAlert.style.display = 'block';
        }
    } catch (e) {
        errorList.innerHTML = '<li>Lỗi kết nối. Vui lòng thử lại.</li>';
        errorAlert.style.display = 'block';
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Cập nhật';
    }
});
</script>

<?php include 'app/views/layout/footer.php'; ?>
