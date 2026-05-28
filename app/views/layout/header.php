<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Quản lý sản phẩm'; ?></title>
    <meta name="theme-color" content="#0d1b2a">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --brand-900: #0b1d34;
            --brand-700: #12345c;
            --brand-500: #1e63a8;
            --brand-300: #69b5f3;
            --accent: #ff8a3d;
            --canvas: #f4f6ef;
            --paper: rgba(255, 255, 255, 0.88);
            --paper-strong: #ffffff;
            --line: rgba(11, 29, 52, 0.14);
            --text-main: #112137;
            --text-soft: #5c6b80;
            --ok: #1f9d73;
            --danger: #d64545;
            --radius-xl: 26px;
            --radius-lg: 20px;
            --radius-md: 14px;
            --shadow-float: 0 20px 45px rgba(17, 33, 55, 0.12);
            --shadow-soft: 0 12px 24px rgba(17, 33, 55, 0.08);
        }
        * {
            box-sizing: border-box;
        }
        body {
            background:
                radial-gradient(circle at 12% 10%, rgba(30, 99, 168, 0.24), transparent 34%),
                radial-gradient(circle at 88% 4%, rgba(255, 138, 61, 0.24), transparent 32%),
                linear-gradient(180deg, #f5f8f2 0%, #edf4fb 48%, #f6f0e5 100%);
            font-family: 'Manrope', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            position: relative;
        }
        body::before,
        body::after {
            content: '';
            position: fixed;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            inset: 0;
            background-image:
                linear-gradient(rgba(17, 33, 55, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(17, 33, 55, 0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.26), transparent 72%);
        }
        body::after {
            top: -120px;
            right: -90px;
            width: 360px;
            height: 360px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(255, 138, 61, 0.34) 0%, rgba(255, 138, 61, 0) 70%);
        }
        .app-shell {
            position: relative;
            z-index: 1;
        }
        .navbar {
            background: linear-gradient(110deg, rgba(11, 29, 52, 0.94), rgba(18, 52, 92, 0.9)) !important;
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow-float);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }
        .navbar-brand {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.06rem;
            letter-spacing: -0.02em;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
        }
        .navbar-brand .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff9f57, #ffd49e);
            color: #512500;
            box-shadow: 0 8px 16px rgba(255, 138, 61, 0.25);
        }
        .navbar .btn-light {
            border: 1px solid rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.09);
            color: #fff;
            border-radius: 999px;
            padding: 0.5rem 0.95rem;
            transition: all 0.24s ease;
            font-weight: 600;
        }
        .navbar .btn-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.45);
            transform: translateY(-2px);
        }
        .main-container {
            margin-top: 1.25rem;
            padding-bottom: 2.75rem;
        }
        .surface-card,
        .page-hero,
        .card {
            border-radius: var(--radius-xl);
            background: var(--paper);
            border: 1px solid var(--line);
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(6px);
        }
        .surface-card {
            animation: fadeUp 0.45s ease;
        }
        .sidebar {
            position: sticky;
            top: 1rem;
            align-self: flex-start;
            max-height: calc(100vh - 2rem);
            overflow: auto;
            padding-right: 0.2rem;
        }
        .sidebar .card {
            overflow: hidden;
            border-radius: 22px;
        }
        .sidebar .card-header {
            background: linear-gradient(145deg, rgba(17, 48, 85, 0.96), rgba(30, 99, 168, 0.94));
            color: #fff;
            border-bottom: 0;
            padding: 1rem 1.1rem;
        }
        .sidebar .list-group {
            padding: 0.7rem;
            gap: 0.3rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(243, 249, 255, 0.92));
        }
        .sidebar .list-group-item {
            border: 0;
            border-radius: 13px !important;
            color: #1f3248;
            font-weight: 600;
            padding: 0.78rem 0.86rem;
            transition: all 0.2s ease;
        }
        .sidebar .list-group-item.active {
            background: linear-gradient(135deg, #173f70, #1e63a8);
            color: #fff;
            box-shadow: 0 10px 20px rgba(20, 58, 102, 0.25);
        }
        .sidebar .list-group-item:not(.active):hover {
            background: rgba(30, 99, 168, 0.13);
            color: #102235;
            transform: translateX(2px);
        }
        .page-hero {
            position: relative;
            overflow: hidden;
            padding: 1.5rem 1.45rem;
            margin-bottom: 1.1rem;
            background: linear-gradient(135deg, rgba(13, 38, 67, 0.96), rgba(25, 78, 134, 0.9));
            color: #fff;
            border: 0;
            box-shadow: var(--shadow-float);
            animation: fadeUp 0.35s ease;
        }
        .page-hero::after {
            content: '';
            position: absolute;
            inset: auto -30px -80px auto;
            width: 210px;
            height: 210px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(255, 138, 61, 0.42), rgba(255, 138, 61, 0) 72%);
        }
        .page-hero h1,
        .page-hero h2,
        .page-hero h3,
        .page-hero h4,
        .page-hero p {
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }
        .page-hero .small,
        .page-hero .lead,
        .page-hero .text-muted {
            color: rgba(232, 243, 255, 0.9) !important;
        }
        .table {
            --bs-table-bg: transparent;
        }
        .table thead th {
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #4b5a6f;
            background: rgba(229, 238, 248, 0.75);
            border-bottom: 1px solid rgba(11, 29, 52, 0.15);
        }
        .table td,
        .table th {
            vertical-align: middle;
            padding: 0.92rem 0.78rem;
            border-color: rgba(17, 33, 55, 0.1);
        }
        .table-hover tbody tr:hover {
            background: rgba(30, 99, 168, 0.06);
        }
        .img-thumbnail {
            border-radius: 14px;
            object-fit: cover;
            border: 1px solid rgba(17, 33, 55, 0.12);
            background: #fff;
        }
        .badge {
            font-weight: 600;
            border-radius: 999px;
            padding: 0.35rem 0.66rem;
        }
        .btn {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.56rem 1rem;
            transition: all 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e63a8, #1a79ca);
            border-color: transparent;
            box-shadow: 0 10px 18px rgba(30, 99, 168, 0.22);
        }
        .btn-warning {
            background: linear-gradient(135deg, #ffb74d, #ff8a3d);
            border-color: transparent;
            color: #2e1700;
        }
        .btn-dark {
            background: linear-gradient(145deg, #10253f, #173f70);
            border-color: transparent;
        }
        .btn-outline-secondary,
        .btn-outline-warning,
        .btn-outline-danger,
        .btn-outline-primary {
            border-width: 1px;
        }
        .form-control,
        .form-select {
            border-radius: var(--radius-md);
            border-color: rgba(17, 33, 55, 0.2);
            padding: 0.72rem 0.95rem;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: none;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: rgba(30, 99, 168, 0.58);
            box-shadow: 0 0 0 0.2rem rgba(30, 99, 168, 0.12);
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1.1rem;
            color: var(--text-soft);
        }
        .app-footer {
            color: var(--text-soft);
            background: linear-gradient(180deg, rgba(250, 253, 255, 0.82), rgba(244, 248, 253, 0.95));
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(17, 33, 55, 0.12) !important;
        }
        .muted-note {
            color: var(--text-soft);
            font-size: 0.93rem;
        }
        .field-card {
            background: rgba(240, 246, 252, 0.78);
            border: 1px solid rgba(17, 33, 55, 0.09);
            border-radius: 16px;
            padding: 1rem;
        }
        @media (max-width: 991.98px) {
            .main-container {
                margin-top: 1rem;
                padding-bottom: 2rem;
            }
            .sidebar {
                position: static;
                max-height: none;
                margin-bottom: 0.9rem;
            }
            .page-hero {
                border-radius: 20px;
                padding: 1.2rem 1.1rem;
            }
        }
        @media (max-width: 575.98px) {
            .navbar-brand {
                font-size: 0.97rem;
            }
            .navbar-brand .brand-mark {
                width: 30px;
                height: 30px;
                border-radius: 9px;
            }
            .btn {
                padding: 0.52rem 0.88rem;
            }
            .surface-card {
                border-radius: 18px;
            }
        }
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$route = trim($_GET['url'] ?? '', '/');
$routeParts = $route === '' ? [] : explode('/', $route);
$routeController = $routeParts[0] ?? '';
$routeAction = $routeParts[1] ?? 'index';
$showSidebar = $routeController === 'Product' && in_array($routeAction, ['index', 'category'], true);
$sidebarCategories = $categories ?? [];
$cartItems = $_SESSION['cart'] ?? [];
$cartCount = 0;
foreach ($cartItems as $cartItem) {
    $cartCount += (int) ($cartItem['quantity'] ?? 0);
}
$flashMessage = $_SESSION['flash_message'] ?? null;
$flashType = $_SESSION['flash_type'] ?? 'success';
unset($_SESSION['flash_message'], $_SESSION['flash_type']);
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/phamgiahuy/Product">
            <span class="brand-mark"><i class="fas fa-cubes"></i></span>
            <span>Quản lý sản phẩm</span>
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
                <li class="nav-item me-2">
                    <a class="btn btn-light btn-sm position-relative" href="/phamgiahuy/Product/cart">
                        <i class="fas fa-cart-shopping me-1"></i>Giỏ hàng
                        <?php if ($cartCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
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
    <?php if (!empty($flashMessage)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($flashType); ?> border-0 shadow-sm rounded-4 mb-3">
            <i class="fas fa-circle-check me-2"></i><?php echo htmlspecialchars($flashMessage); ?>
        </div>
    <?php endif; ?>
    <div class="row align-items-start">
        <?php if ($showSidebar): ?>
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-folder me-2"></i>Danh mục
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="/phamgiahuy/Product" class="list-group-item list-group-item-action <?php echo !isset($current_category) ? 'active' : ''; ?>">
                        <i class="fas fa-boxes me-2"></i>Tất cả
                    </a>
                    <?php foreach ($sidebarCategories as $category): ?>
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