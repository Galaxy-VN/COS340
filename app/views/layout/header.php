<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Quản lý sản phẩm'; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
        }
        .main-container {
            margin-top: 1.5rem;
        }
        .sidebar {
            position: sticky;
            top: 90px;
            height: fit-content;
        }
        .sidebar .list-group-item {
            border: none;
            padding: 0.75rem 1rem;
        }
        .sidebar .list-group-item.active {
            background: var(--primary-color);
            border-radius: 8px;
            margin: 2px 0;
        }
        .sidebar .list-group-item:not(.active) {
            color: #333;
        }
        .sidebar .list-group-item:not(.active):hover {
            background-color: #e9ecef;
            border-radius: 8px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #eee;
            padding: 1rem 1.25rem;
        }
        .table td, .table th {
            vertical-align: middle;
            padding: 0.75rem;
        }
        .img-thumbnail {
            border-radius: 8px;
            object-fit: cover;
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/phamgiahuy/Product">
            <i class="fas fa-box-open me-2"></i>Quản lý sản phẩm
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a class="btn btn-light btn-sm" href="/phamgiahuy/Product">
                        <i class="fas fa-box me-1"></i>Sản phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-light btn-sm" href="/phamgiahuy/Category">
                        <i class="fas fa-folder me-1"></i>Danh mục
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid main-container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-folder me-2"></i>Danh mục
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="/phamgiahuy/Product" class="list-group-item list-group-item-action active">
                        <i class="fas fa-boxes me-2"></i>Tất cả
                    </a>
                    <?php foreach ($categories as $category): ?>
                        <a href="/phamgiahuy/Product/category/<?php echo $category->id; ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-folder me-2"></i><?php echo htmlspecialchars($category->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10">
            <?php if (isset($current_category)): ?>
                <div class="alert alert-info d-flex align-items-center" style="margin: 0 0 1rem 0;">
                    <i class="fas fa-folder-open me-2"></i>
                    <div class="flex-grow-1">
                        <strong>Danh mục:</strong> <?php echo htmlspecialchars($current_category->name); ?>
                        <?php if (!empty($current_category->description)): ?>
                            — <?php echo htmlspecialchars($current_category->description); ?>
                        <?php endif; ?>
                    </div>
                    <a href="/phamgiahuy/Product" class="btn btn-sm btn-outline-secondary">Xem tất cả</a>
                </div>
            <?php endif; ?>