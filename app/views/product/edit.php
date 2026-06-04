<?php $title = 'Chỉnh sửa sản phẩm'; ?>
<?php $product = $product ?? (object) ['id' => '', 'name' => '', 'description' => '', 'category_id' => '', 'price' => '', 'image' => '']; ?>
<?php $categories = $categories ?? []; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="page-hero d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase fw-semibold opacity-75">
            <i class="fas fa-pen-to-square"></i>
            <span>Edit item</span>
        </div>
        <h1 class="h3 mb-2 fw-bold">Chỉnh sửa sản phẩm</h1>
        <p class="lead mb-0">Điều chỉnh thông tin sản phẩm và cập nhật ảnh theo từng lần chỉnh sửa.</p>
    </div>
    <a href="/phamgiahuy/product" class="btn btn-light text-primary fw-semibold shadow-sm position-relative" style="z-index:1;">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="surface-card p-3 p-lg-4">
            <form action="/phamgiahuy/product/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">

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

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Ảnh hiện tại</label>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background: rgba(237, 244, 250, 0.75); border: 1px solid rgba(17, 33, 55, 0.08);">
                            <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="Ảnh" class="img-thumbnail" width="96" height="96">
                            <?php else: ?>
                                <div class="bg-white d-flex align-items-center justify-content-center rounded-4 border" style="width: 96px; height: 96px;">
                                    <i class="fas fa-image text-muted fa-lg"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="fw-semibold mb-1">Ảnh sản phẩm</div>
                                <div class="text-muted small">Nếu không chọn ảnh mới, ảnh hiện tại sẽ được giữ nguyên.</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="image" class="form-label fw-semibold">Thay đổi ảnh</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Cập nhật
                    </button>
                    <a href="/phamgiahuy/product" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
