<?php $title = 'Thêm danh mục'; ?>
<?php include 'app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-primary"><i class="fas fa-plus me-2"></i>Thêm danh mục</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <div><?php echo htmlspecialchars($error); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="/phamgiahuy/Category/save" method="POST">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-tag me-1"></i>Tên *</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-align-left me-1"></i>Mô tả</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Lưu</button>
                        <a href="/phamgiahuy/Category" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>
