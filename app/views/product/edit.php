<?php $title = 'Chỉnh sửa sản phẩm • COS340 Store'; ?>
<?php $product = $product ?? (object) ['id' => '', 'name' => '', 'description' => '', 'category_id' => '', 'price' => '', 'image' => '']; ?>
<?php $categories = $categories ?? []; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Form Page -->
<style>
    .form-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .edit-thumbnail-wrap {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        flex-shrink: 0;
    }
    .edit-thumbnail-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<!-- Form Hero Header -->
<div class="form-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-pencil-line text-primary"></i>
            <span>Chỉnh sửa</span>
        </div>
        <h1 class="h2 fw-bold text-white mb-2">Chỉnh Sửa Thiết Bị</h1>
        <p class="text-muted mb-0">Cập nhật thông tin chi tiết, thay đổi giá bán hoặc đổi ảnh sản phẩm.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-glass d-flex align-items-center gap-2">
        <i class="ph ph-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="surface-card p-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <div class="fw-bold mb-1"><i class="ph ph-warning-circle"></i> Vui lòng sửa các lỗi sau:</div>
                    <ul class="mb-0 ps-3 small">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/phamgiahuy/product/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                <div class="field-card mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-white mb-1">Mã sản phẩm: #<?php echo $product->id; ?></h5>
                        <div class="text-muted small">Cập nhật thông tin và kiểm tra kết quả ngay lập tức.</div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10 px-2.5 py-1.5">Chế độ sửa</span>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tên sản phẩm *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product->name); ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Mô tả sản phẩm</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($product->description); ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Danh mục thiết bị *</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $product->category_id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Giá bán (VNĐ) *</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product->price); ?>" step="0.01" min="0" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Hình ảnh hiện tại</label>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">
                            <div class="edit-thumbnail-wrap">
                                <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                    <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="Thumbnail">
                                <?php else: ?>
                                    <div class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center">
                                        <i class="ph ph-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="fw-semibold text-white">Ảnh đại diện cũ</div>
                                <div class="text-muted small">Nếu chọn tệp mới bên dưới, hệ thống sẽ thay thế ảnh này.</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Tải ảnh thay thế</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="text-muted small mt-2">Hỗ trợ định dạng JPG, PNG, GIF, WEBP. Dung lượng tối đa 5MB.</div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top border-white border-opacity-5 d-flex gap-2">
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2.5 rounded-3 d-flex align-items-center gap-1">
                        <i class="ph ph-floppy-disk-back"></i> Cập nhật thiết bị
                    </button>
                    <a href="/phamgiahuy/product" class="btn btn-glass px-4 py-2.5 rounded-3">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
