<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Quản lý sản phẩm'; ?></title>
    <meta name="theme-color" content="#0f172a">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --accent-color: #14b8a6;
            --surface: rgba(255, 255, 255, 0.82);
            --surface-strong: #ffffff;
            --border-color: rgba(148, 163, 184, 0.2);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --shadow-soft: 0 16px 40px rgba(15, 23, 42, 0.08);
            --shadow-card: 0 10px 30px rgba(15, 23, 42, 0.08);
            --radius-lg: 24px;
            --radius-md: 18px;
        }
        body {
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.12), transparent 28%),
                radial-gradient(circle at top right, rgba(20, 184, 166, 0.12), transparent 30%),
                linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-main);
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(15, 23, 42, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(15, 23, 42, 0.03) 1px, transparent 1px);
            background-size: 34px 34px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.22), transparent 65%);
        }
        .app-shell {
            position: relative;
            z-index: 1;
        }
        .navbar {
            background: rgba(15, 23, 42, 0.72) !important;
            backdrop-filter: blur(16px);
            box-shadow: var(--shadow-soft);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.02em;
        }
        .navbar .btn-light {
            border: none;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-radius: 999px;
            padding: 0.55rem 1rem;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .navbar .btn-light:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }
        .main-container {
            margin-top: 1.5rem;
            padding-bottom: 2.5rem;
        }
        .sidebar .card,
        .card,
        .surface-card,
        .page-hero {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            background: var(--surface);
            backdrop-filter: blur(18px);
            box-shadow: var(--shadow-card);
        }
        .sidebar {
            position: sticky;
            top: 1.25rem;
            align-self: flex-start;
            max-height: calc(100vh - 2.5rem);
            overflow: auto;
        }
        .sidebar .card {
            overflow: hidden;
        }
        .sidebar .list-group-item {
            border: none;
            padding: 0.9rem 1rem;
            margin: 0.15rem 0.75rem;
            border-radius: 14px !important;
            color: var(--text-main);
            font-weight: 500;
            transition: background 0.2s ease, transform 0.2s ease, color 0.2s ease;
        }
        .sidebar .list-group-item.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: #fff;
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
        }
        .sidebar .list-group-item:not(.active) {
            color: #334155;
        }
        .sidebar .list-group-item:not(.active):hover {
            background-color: rgba(37, 99, 235, 0.08);
            transform: translateX(2px);
        }
        .card {
            overflow: hidden;
        }
        .card-header {
            background: rgba(255, 255, 255, 0.7);
            border-bottom: 1px solid rgba(148, 163, 184, 0.16);
            padding: 1rem 1.25rem;
        }
        .table td, .table th {
            vertical-align: middle;
            padding: 0.95rem 0.8rem;
            border-color: rgba(148, 163, 184, 0.16);
        }
        .img-thumbnail {
            border-radius: 14px;
            object-fit: cover;
            border: 1px solid rgba(148, 163, 184, 0.14);
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 999px;
        }
        .page-hero {
            padding: 1.35rem 1.4rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.95), rgba(20, 184, 166, 0.86));
            color: #fff;
            border: none;
        }
        .page-hero h1,
        .page-hero h2,
        .page-hero h3,
        .page-hero h4,
        .page-hero p {
            margin-bottom: 0;
        }
        .page-hero .text-muted,
        .page-hero .small,
        .page-hero .lead {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        .btn {
            border-radius: 999px;
            font-weight: 600;
            padding: 0.62rem 1rem;
        }
        .btn-sm {
            padding: 0.45rem 0.85rem;
        }
        .btn-outline-secondary,
        .btn-outline-warning,
        .btn-outline-danger,
        .btn-outline-primary {
            border-width: 1px;
        }
        .form-control,
        .form-select {
            border-radius: 14px;
            border-color: rgba(148, 163, 184, 0.25);
            padding: 0.75rem 0.95rem;
            box-shadow: none;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: rgba(37, 99, 235, 0.5);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
        }
        .table thead th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            background: rgba(248, 250, 252, 0.95);
        }
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: var(--text-muted);
        }
        .app-footer {
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.68);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body>
<?php
$route = trim($_GET['url'] ?? '', '/');
$routeParts = $route === '' ? [] : explode('/', $route);
$routeController = $routeParts[0] ?? '';
$routeAction = $routeParts[1] ?? 'index';
$showSidebar = $routeController === 'Product' && in_array($routeAction, ['index', 'category'], true);
?>
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
<div class="app-shell">
<div class="container-fluid main-container">
    <div class="row align-items-start">
        <?php if ($showSidebar): ?>
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-folder me-2"></i>Danh mục
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="/phamgiahuy/Product" class="list-group-item list-group-item-action <?php echo !isset($current_category) ? 'active' : ''; ?>">
                        <i class="fas fa-boxes me-2"></i>Tất cả
                    </a>
                    <?php foreach ($categories as $category): ?>
                        <a href="/phamgiahuy/Product/category/<?php echo $category->id; ?>" class="list-group-item list-group-item-action <?php echo (isset($current_category) && $current_category->id == $category->id) ? 'active' : ''; ?>">
                            <i class="fas fa-folder me-2"></i><?php echo htmlspecialchars($category->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-lg-10">
        <?php else: ?>
        <div class="col-12">
        <?php endif; ?>