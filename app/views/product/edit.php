<?php $title = 'Chỉnh sửa sản phẩm'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Chỉnh sửa sản phẩm</h4>
                </div>
                <div class="card-body">
                    <form action="/phamgiahuy/Product/edit/<?php echo htmlspecialchars($product->getID()); ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product->getName()); ?>" placeholder="Nhập tên sản phẩm" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Nhập mô tả sản phẩm"><?php echo htmlspecialchars($product->getDescription()); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product->getPricen()); ?>" placeholder="Nhập giá sản phẩm" step="0.01" min="0.01" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                            <a href="/phamgiahuy/Product/list" class="btn btn-outline-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>