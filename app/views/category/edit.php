<?php $title = 'Chỉnh sửa danh mục'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="mb-0 text-warning"><i class="fas fa-edit me-2"></i>Chỉnh sửa danh mục</h4>
                </div>
                <div class="card-body px-4">
                    <form action="/phamgiahuy/Category/update" method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($category->id); ?>">

                        <div class="mb-3">
                            <label for="name" class="form-label"><i class="fas fa-tag me-1"></i>Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category->name); ?>" placeholder="Nhập tên danh mục" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label"><i class="fas fa-align-left me-1"></i>Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Nhập mô tả danh mục"><?php echo htmlspecialchars($category->description); ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i>Cập nhật
                            </button>
                            <a href="/phamgiahuy/Category" class="btn btn-outline-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
