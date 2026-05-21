<?php $title = 'Chỉnh sửa sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-warning">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa sản phẩm
                </h4>
            </div>
            <div class="card-body">
                <form action="/phamgiahuy/Product/update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label"><i class="fas fa-tag me-1"></i>Tên *</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="<?php echo htmlspecialchars($product->name); ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label"><i class="fas fa-align-left me-1"></i>Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product->description); ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label"><i class="fas fa-folder me-1"></i>Danh mục *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Chọn --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>"
                                        <?php echo ($category->id == $product->category_id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label"><i class="fas fa-money-bill me-1"></i>Giá *</label>
                            <input type="number" class="form-control" id="price" name="price"
                                   value="<?php echo htmlspecialchars($product->price); ?>" step="0.01" min="0" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-image me-1"></i>Ảnh hiện tại</label>
                            <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>"
                                     alt="Ảnh" class="img-thumbnail mb-2" width="120" height="120">
                            <?php else: ?>
                                <p class="text-muted">Chưa có ảnh</p>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="image" class="form-label"><i class="fas fa-upload me-1"></i>Thay đổi ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Cập nhật
                        </button>
                        <a href="/phamgiahuy/Product" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
