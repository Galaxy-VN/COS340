<?php $title = 'Thêm sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thêm sản phẩm mới</h4>
                </div>
                <div class="card-body px-4">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/phamgiahuy/Product/add" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" placeholder="Nhập tên sản phẩm" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Nhập mô tả sản phẩm"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" placeholder="Nhập giá sản phẩm" step="0.01" min="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh <span class="text-secondary">(optional)</span></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Chấp nhận JPG, JPEG, PNG, GIF, WEBP — tối đa 5MB.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                            <a href="/phamgiahuy/Product/list" class="btn btn-outline-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>