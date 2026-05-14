<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Danh sách sản phẩm</h4>
                        <a href="/phamgiahuy/Product/add" class="btn btn-light text-primary">Thêm sản phẩm</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($products)): ?>
                            <div class="alert alert-info mb-0">
                                Chưa có sản phẩm nào. <a href="/phamgiahuy/Product/add" class="alert-link">Thêm sản phẩm mới</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Mô tả</th>
                                            <th>Giá</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product->getID()); ?></td>
                                            <td><?php echo htmlspecialchars($product->getName()); ?></td>
                                            <td><?php echo htmlspecialchars($product->getDescription()); ?></td>
                                            <td><?php echo number_format($product->getPricen(), 0, ',', '.'); ?> VNĐ</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="/phamgiahuy/Product/edit/<?php echo $product->getID(); ?>" class="btn btn-outline-warning">Sửa</a>
                                                    <a href="/phamgiahuy/Product/delete/<?php echo $product->getID(); ?>" class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>