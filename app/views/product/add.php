<?php $title = 'Thêm sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-primary">
                    <i class="fas fa-plus-circle me-2"></i>Thêm sản phẩm mới
                </h4>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/phamgiahuy/Product/save" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label"><i class="fas fa-tag me-1"></i>Tên sản phẩm *</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label"><i class="fas fa-align-left me-1"></i>Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label"><i class="fas fa-folder me-1"></i>Danh mục *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Chọn --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>"
                                        <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label"><i class="fas fa-money-bill me-1"></i>Giá *</label>
                            <input type="number" class="form-control" id="price" name="price"
                                   value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" step="0.01" min="0" required>
                        </div>

                        <div class="col-md-12">
                            <label for="image" class="form-label"><i class="fas fa-image me-1"></i>Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">JPG, PNG, GIF, WEBP - tối đa 5MB</small>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Lưu
                        </button>
                        <a href="/phamgiahuy/Product" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
