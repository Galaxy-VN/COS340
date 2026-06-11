<?php $title = 'Thêm sản phẩm'; ?>
<?php $categories = $categories ?? []; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-plus-circle"></i>
            <span>New item</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Thêm sản phẩm mới</h1>
        <p class="lead mb-0">Điền thông tin cốt lõi để sản phẩm xuất hiện ngay trong danh sách quản trị.</p>
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
                <div class="field-card mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-circle-info text-primary"></i>
                        <div class="fw-semibold">Thông tin cơ bản</div>
                    </div>
                    <div class="muted-note">Các trường có dấu * là bắt buộc trước khi lưu.</div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold">Tên sản phẩm *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">Danh mục *</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">Giá *</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-1"></i>Lưu
                    </button>
                    <a href="/phamgiahuy/product" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const API_BASE = '/phamgiahuy/api';

document.getElementById('productForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const errorAlert = document.getElementById('errorAlert');
    const errorList = document.getElementById('errorList');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang lưu...';
    errorAlert.style.display = 'none';

    const data = {
        name: document.getElementById('name').value.trim(),
        description: document.getElementById('description').value.trim(),
        price: parseFloat(document.getElementById('price').value) || 0,
        category_id: parseInt(document.getElementById('category_id').value) || 0
    };

    try {
        const resp = await fetch(`${API_BASE}/product`, {
            method: 'POST',
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
        submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Lưu';
    }
});
</script>

<?php include 'app/views/layout/footer.php'; ?>
