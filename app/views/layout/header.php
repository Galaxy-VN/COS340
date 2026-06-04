<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Quản lý sản phẩm'; ?></title>
    <meta name="theme-color" content="#0d1b2a">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- jQuery DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        :root {
            /* Liquid Glass Theme */
            --brand-900: #0f172a;
            --brand-700: #1e293b;
            --brand-500: #3b82f6;
            --brand-300: #93c5fd;
            --accent: #f43f5e;
            --accent-glow: rgba(244, 63, 94, 0.5);
            --canvas: #09090b;
            --paper: rgba(30, 41, 59, 0.45);
            --paper-strong: rgba(30, 41, 59, 0.7);
            --line: rgba(255, 255, 255, 0.12);
            --text-main: #f8fafc;
            --text-soft: #94a3b8;
            --ok: #10b981;
            --danger: #ef4444;
            --radius-xl: 32px;
            --radius-lg: 24px;
            --radius-md: 16px;
            --shadow-float: 0 32px 64px rgba(0, 0, 0, 0.5);
            --shadow-soft: 0 16px 32px rgba(0, 0, 0, 0.3);
            --glass-blur: blur(24px);
            --glass-border: 1px solid rgba(255, 255, 255, 0.15);
            --liquid-highlight: inset 0 1px 1px rgba(255, 255, 255, 0.3);
        }
        * {
            box-sizing: border-box;
        }
        body {
            background-color: var(--canvas);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.25), transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(244, 63, 94, 0.2), transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(147, 197, 253, 0.1), transparent 50%);
            background-attachment: fixed;
            font-family: 'Noto Sans', 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text-main);
            min-height: 100vh;
            min-height: 100dvh;
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
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.8), transparent 80%);
        }
        body::after {
            top: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(244, 63, 94, 0.3) 0%, transparent 60%);
            filter: blur(80px);
            animation: float-blob 20s infinite alternate;
        }
        @keyframes float-blob {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-50px, 30px) scale(1.1); }
            100% { transform: translate(20px, 80px) scale(0.9); }
        }
        .app-shell {
            position: relative;
            z-index: 1;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.04) !important;
            backdrop-filter: blur(8px) saturate(120%);
            -webkit-backdrop-filter: var(--glass-blur);
            box-shadow: 0 6px 20px rgba(2,6,23,0.45);
            border: 1px solid rgba(255,255,255,0.04);
            padding: 0.45rem 0.6rem;
            margin: 1rem auto;
            border-radius: 14px;
            max-width: calc(100% - 2rem);
            position: sticky;
            top: 10px;
            z-index: 1020;
        }
        .navbar-brand {
            font-family: 'Poppins', 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: -0.02em;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--text-main) !important;
        }
        .navbar-brand .brand-mark {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--brand-500), var(--accent));
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4), var(--liquid-highlight);
            color: white;
            font-size: 1.2rem;
            border: 1px solid rgba(255,255,255,0.4);
        }
        /* Modern minimal header overrides */
        .navbar .container-fluid { display:flex; align-items:center; gap:0.75rem; }
        .header-search { flex: 1 1 540px; max-width: 640px; }
        .header-search .form-control { border-radius: 999px; padding: 0.45rem 0.9rem; font-size: 0.95rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); color: var(--text-main); }
        .cart-badge { position: relative; font-size: 0.65rem; top: -8px; left: -8px; }
        @media (max-width: 767.98px) {
            .header-search { display: none; }
            .navbar { padding: 0.35rem 0.4rem; }
            .navbar-brand { font-size: 0.95rem; }
            .navbar-brand .brand-mark { width: 34px; height: 34px; }
        }
        
        /* Headers */
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: 'Poppins', 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
        }

        /* Surface Cards / Liquid Glass Panels */
        .surface-card,
        .card,
        .modal-content {
            background: var(--paper) !important;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: var(--glass-border) !important;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            color: var(--text-main);
            box-shadow: var(--liquid-highlight);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
        }
        .surface-card:hover {
            transform: translateY(-4px) scale(1.005);
            box-shadow: var(--shadow-float), var(--liquid-highlight), 0 0 20px rgba(59, 130, 246, 0.15);
        }
        
        /* Icons styling */
        i.fas, i.fa-solid, i.fab, i.far {
            background: linear-gradient(135deg, var(--brand-300), var(--brand-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
        .btn i.fas, .navbar-brand .brand-mark i, .badge i.fas, .sidebar .list-group-item.active i.fas {
            background: none;
            -webkit-text-fill-color: currentColor;
            color: inherit;
        }

        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            background: rgba(30, 41, 59, 0.2);
            border-radius: var(--radius-lg);
            border: 1px dashed rgba(255,255,255,0.2);
        }

        .table {
            color: var(--text-main);
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-main);
            --bs-table-hover-bg: rgba(255, 255, 255, 0.08);
            --bs-table-hover-color: var(--text-main);
            border-collapse: separate;
            border-spacing: 0 0.4rem;
            font-size: 0.9rem;
        }
        .table > :not(caption) > * > * {
            border-bottom: none;
            padding: 1rem 1.2rem;
            background: rgba(30, 41, 59, 0.2);
        }
        .table > tbody > tr > td:first-child, .table > thead > tr > th:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }
        .table > tbody > tr > td:last-child, .table > thead > tr > th:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }
        thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            color: var(--brand-300);
            background: transparent !important;
            border-bottom: none !important;
            padding-bottom: 0.5rem !important;
        }
        .table-hover > tbody > tr {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .table-hover > tbody > tr:hover {
            transform: scale(1.01) translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2), var(--liquid-highlight);
        }
        .table-hover > tbody > tr:hover > * {
            box-shadow: inset 0 0 0 9999px var(--bs-table-hover-bg);
            color: var(--bs-table-hover-color);
        }

        /* DataTables (jQuery) overrides to match Liquid Glass theme */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255,255,255,0.12);
            color: var(--text-main);
            border-radius: 10px;
            padding: 0.45rem 0.7rem;
            outline: none;
            transition: all 0.2s ease;
        }
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-soft);
            margin-right: 0.5rem;
            font-size: 0.95rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-main) !important;
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid rgba(255,255,255,0.06) !important;
            border-radius: 8px !important;
            margin: 0 4px !important;
            padding: 0.35rem 0.6rem !important;
        }
        .dataTables_wrapper .dataTables_info {
            color: var(--text-soft);
        }
        
        /* Buttons */
        .btn {
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            letter-spacing: 0.01em;
            padding: 0.5rem 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--brand-500), #2563eb);
            border: none;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4), inset 0 1px 1px rgba(255,255,255,0.4);
            border-radius: 12px;
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.6), inset 0 1px 1px rgba(255,255,255,0.5);
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }
        .btn-warning {
            background: linear-gradient(135deg, var(--accent), #e11d48);
            border: none;
            box-shadow: 0 4px 15px var(--accent-glow), inset 0 1px 1px rgba(255,255,255,0.4);
            border-radius: 12px;
            color: #fff !important;
            transition: all 0.3s ease;
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--accent-glow), inset 0 1px 1px rgba(255,255,255,0.5);
            background: linear-gradient(135deg, #e11d48, #be123c);
        }
        .btn-light, .btn-outline-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.1);
        }
        .btn-light:hover, .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-color: rgba(255,255,255,0.3);
        }

        /* Glass-style button for subtle CTA (used in order detail for Mua lại / Xem) */
        .btn-glass {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: var(--text-main);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: 10px;
            padding: 0.35rem 0.7rem;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.03);
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-glass:hover {
            background: rgba(255,255,255,0.12);
            transform: translateY(-2px);
            color: #fff;
        }
        .btn-glass.btn-sm {
            padding: 0.275rem 0.5rem;
            font-size: 0.86rem;
        }

        /* Compact action buttons in tables */
        .table .btn, .btn-group .btn {
            padding: 0.35rem 0.55rem;
            font-size: 0.88rem;
            border-radius: 10px;
            min-width: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .table .btn i, .btn-group .btn i {
            margin: 0;
            font-size: 0.95rem;
        }
        /* Ensure outline variants match rounded style */
        .btn-outline-primary, .btn-outline-warning, .btn-outline-danger, .btn-outline-success, .btn-outline-secondary {
            border-radius: 10px;
            border-width: 1px;
            padding: 0.35rem 0.55rem;
        }

        /* Make datatable controls more compact */
        .datatable-top .datatable-selector, .datatable-top .datatable-input {
            padding: 0.35rem 0.6rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .datatable-wrapper .datatable-bottom {
            padding: 0.25rem 0;
        }
        /* Table action buttons: remove borders and make flat icons */
        .table .btn, .table .btn-outline-primary, .table .btn-outline-warning, .table .btn-outline-danger, .table .btn-outline-success, .table .btn-outline-secondary {
            background: transparent !important;
            color: inherit !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0.35rem 0.5rem !important;
        }
        .table .btn i {
            background: none !important;
            -webkit-text-fill-color: currentColor !important;
            color: inherit !important;
            display: inline-block;
        }
        
        .badge {
            border-radius: 6px;
            padding: 0.4em 0.75em;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            font-size: 0.7em;
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.2);
            backdrop-filter: blur(4px);
        }
        .bg-primary-subtle, .bg-info.bg-opacity-10 {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #93c5fd !important;
            border: 1px solid rgba(147, 197, 253, 0.3) !important;
        }
        
        input.form-control, select.form-select, textarea.form-control {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255,255,255,0.15);
            color: var(--text-main);
            border-radius: 10px;
            backdrop-filter: var(--glass-blur);
            transition: all 0.3s ease;
            font-size: 0.95rem;
            padding: 0.6rem 0.85rem;
        }
        input.form-control:focus, select.form-select:focus, textarea.form-control:focus {
            background: rgba(15, 23, 42, 0.6);
            border-color: var(--brand-500);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3), inset 0 1px 1px rgba(255,255,255,0.2);
            color: var(--text-main);
            transform: translateY(-1px);
        }
        
        .nav-link {
            color: var(--text-main) !important;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            opacity: 1;
            text-shadow: 0 0 8px rgba(255,255,255,0.3);
        }
        .muted-note {
            color: var(--text-soft);
        }
        .img-thumbnail {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
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
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.8), rgba(30, 41, 59, 0.8));
            backdrop-filter: blur(12px);
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 1rem 1.1rem;
        }
        .sidebar .list-group {
            padding: 0.7rem;
            gap: 0.3rem;
            background: rgba(15, 23, 42, 0.4);
        }
        .sidebar .list-group-item {
            border: 0;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 13px !important;
            color: var(--text-main);
            font-weight: 600;
            padding: 0.78rem 0.86rem;
            transition: all 0.2s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar .list-group-item.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(37, 99, 235, 0.8));
            color: #fff;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            border-color: rgba(255,255,255,0.2);
        }
        .sidebar .list-group-item:not(.active):hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(2px);
            border-color: rgba(255,255,255,0.15);
        }
        .page-hero {
            position: relative;
            overflow: hidden;
            padding: 1.5rem 1.45rem;
            margin-bottom: 1.1rem;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.8));
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: var(--glass-border);
            border-radius: var(--radius-xl);
            color: #fff;
            box-shadow: var(--shadow-float), var(--liquid-highlight);
            animation: fadeUp 0.35s ease;
        }
        .page-hero::after {
            content: '';
            position: absolute;
            inset: auto -30px -80px auto;
            width: 210px;
            height: 210px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.4), transparent 70%);
            mix-blend-mode: screen;
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
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .badge {
            font-weight: 600;
            border-radius: 999px;
            padding: 0.35rem 0.66rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1.1rem;
            color: var(--text-soft);
        }
        .app-footer {
            color: var(--text-soft);
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-top: var(--glass-border) !important;
        }
        .muted-note {
            color: var(--text-soft);
            font-size: 0.93rem;
        }
        .field-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 1rem;
            backdrop-filter: blur(10px);
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
        html { scroll-behavior: smooth; }

        /* Active nav link: brand accent */
        .nav-link.active {
            color: var(--brand-300) !important;
            opacity: 1;
        }

        /* Focus ring for keyboard accessibility */
        .btn-glass:focus-visible,
        .btn-primary:focus-visible,
        .navbar .btn-light:focus-visible {
            outline: 2px solid var(--brand-500);
            outline-offset: 2px;
        }

        /* Active/pressed feedback */
        .btn-glass:active {
            transform: translateY(0) scale(0.97);
            background: rgba(255,255,255,0.08);
            transition-duration: 0.08s;
        }
        .btn-primary:active {
            transform: translateY(0) scale(0.97);
            transition-duration: 0.08s;
        }
        .navbar .btn-light:active {
            transform: translateY(0) scale(0.97);
            transition-duration: 0.08s;
        }

        /* Logout icon: replace inline style */
        .logout-icon { font-size: 0.8em; opacity: 0.7; }
    </style>
</head>
<body>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$route = trim($_GET['url'] ?? '', '/');
$routeParts = $route === '' ? [] : explode('/', $route);
$routeController = isset($routeParts[0]) ? ucfirst(strtolower($routeParts[0])) : '';
$routeAction = isset($routeParts[1]) ? strtolower($routeParts[1]) : 'index';
$showSidebar = $routeController === 'Product' && in_array($routeAction, ['index', 'category'], true);
$sidebarCategories = $categories ?? [];
$cartUsername = $_SESSION['username'] ?? 'guest';
$cartItems = $_SESSION['cart_' . $cartUsername] ?? [];
$cartCount = 0;
foreach ($cartItems as $cartItem) {
    $cartCount += (int) ($cartItem['quantity'] ?? 0);
}
$flashMessage = $_SESSION['flash_message'] ?? null;
$flashType = $_SESSION['flash_type'] ?? 'success';
unset($_SESSION['flash_message'], $_SESSION['flash_type']);
$isProduct = $routeController === 'Product';
$isOrders = $isProduct && $routeAction === 'orders';
$isCart = $isProduct && $routeAction === 'cart';
$isCategory = $routeController === 'Category';
$isHome = $routeController === '' || ($isProduct && $routeAction === 'index');
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/phamgiahuy/product">
            <span class="brand-mark"><i class="fas fa-cubes"></i></span>
            <span>Quản lý sản phẩm</span>
        </a>

        <div class="header-search d-none d-md-block">
            <form action="/phamgiahuy/product" method="GET" class="w-100">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Tìm sản phẩm, mã SP..." value="<?php echo htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button class="btn btn-light" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <!-- Cart button (always visible) + Hamburger toggler (mobile only) -->
        <div class="d-flex align-items-center gap-2 ms-auto">
            <button class="btn btn-primary position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer" aria-controls="cartDrawer" title="Giỏ hàng">
                <i class="fas fa-cart-shopping"></i>
                <?php if ($cartCount > 0): ?>
                    <span class="badge bg-warning text-dark cart-badge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </button>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Single responsive collapse: desktop icons + mobile text links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Desktop: icon buttons (hidden on mobile) -->
            <div class="d-none d-md-flex align-items-center gap-2 ms-auto">
                <a href="/phamgiahuy/product/orders" class="btn btn-glass" title="Đơn hàng">
                    <i class="fas fa-receipt"></i>
                </a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/phamgiahuy/product/manageOrders" class="btn btn-glass" title="Quản lý đơn hàng">
                        <i class="fas fa-tasks"></i>
                    </a>
                    <a href="/phamgiahuy/category" class="btn btn-glass" title="Danh mục">
                        <i class="fas fa-folder"></i>
                    </a>
                <?php endif; ?>
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="/phamgiahuy/account/profile" class="btn btn-glass d-inline-flex align-items-center gap-2" title="Hồ sơ cá nhân">
                        <?php if (!empty($_SESSION['avatar']) && file_exists('uploads/' . $_SESSION['avatar'])): ?>
                            <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($_SESSION['avatar']); ?>" class="rounded-circle" style="width: 24px; height: 24px; object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                <?php echo strtoupper(substr($_SESSION['username'], 0, 2)); ?>
                            </div>
                        <?php endif; ?>
                        <span><?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']); ?></span>
                    </a>
                    <a href="/phamgiahuy/account/logout" class="btn btn-glass" title="Đăng xuất" onclick="return confirm('Bạn muốn đăng xuất?')">
                        <i class="fas fa-right-from-bracket logout-icon"></i>
                    </a>
                <?php else: ?>
                    <a href="/phamgiahuy/account/login" class="btn btn-glass" title="Đăng nhập">
                        <i class="fas fa-right-to-bracket"></i>
                    </a>
                    <a href="/phamgiahuy/account/register" class="btn btn-glass" title="Đăng ký">
                        <i class="fas fa-user-plus"></i>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile: text links (hidden on desktop) -->
            <ul class="navbar-nav d-md-none ms-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo $isHome ? 'active' : ''; ?>" href="/phamgiahuy/product"><i class="fas fa-box me-1"></i> Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $isCart ? 'active' : ''; ?>" href="/phamgiahuy/product/cart"><i class="fas fa-cart-shopping me-1"></i> Giỏ hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $isOrders ? 'active' : ''; ?>" href="/phamgiahuy/product/orders"><i class="fas fa-receipt me-1"></i> Đơn hàng</a>
                </li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/phamgiahuy/product/manageOrders"><i class="fas fa-tasks me-1"></i> Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $isCategory ? 'active' : ''; ?>" href="/phamgiahuy/category"><i class="fas fa-folder me-1"></i> Danh mục</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="/phamgiahuy/account/profile">
                            <?php if (!empty($_SESSION['avatar']) && file_exists('uploads/' . $_SESSION['avatar'])): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($_SESSION['avatar']); ?>" class="rounded-circle" style="width: 20px; height: 20px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 20px; height: 20px; font-size: 0.65rem;">
                                    <?php echo strtoupper(substr($_SESSION['username'], 0, 2)); ?>
                                </div>
                            <?php endif; ?>
                            <span>Hồ sơ: <?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/phamgiahuy/account/logout" onclick="return confirm('Bạn muốn đăng xuất?')">
                            <i class="fas fa-right-from-bracket me-1"></i> Đăng xuất
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/phamgiahuy/account/login"><i class="fas fa-right-to-bracket me-1"></i> Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/phamgiahuy/account/register"><i class="fas fa-user-plus me-1"></i> Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Cart Drawer Offcanvas -->
<div class="offcanvas offcanvas-end text-dark" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartDrawerLabel"><i class="fas fa-cart-shopping me-2"></i>Giỏ hàng</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="p-3">
            <?php if (empty($cartItems)): ?>
                <div class="empty-state">
                    <p class="mb-0">Giỏ hàng trống</p>
                </div>
            <?php else: ?>
                <div class="list-group">
                    <?php $cartTotal = 0; foreach ($cartItems as $ci): ?>
                        <?php $line = ((float)($ci['price'] ?? 0)) * ((int)($ci['quantity'] ?? 0)); $cartTotal += $line; ?>
                        <div class="list-group-item d-flex align-items-center gap-3">
                            <div style="width:64px; height:64px; flex-shrink:0;">
                                <?php if (!empty($ci['image']) && file_exists('uploads/' . $ci['image'])): ?>
                                    <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($ci['image']); ?>" class="img-thumbnail" style="width:64px; height:64px; object-fit:cover; border-radius:10px;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-2" style="width:64px; height:64px;"><i class="fas fa-image text-muted"></i></div>
                                <?php endif; ?>
                            </div>
                            <div style="flex:1 1 auto; min-width:0;">
                                <div class="fw-semibold text-truncate"><?php echo htmlspecialchars($ci['name'] ?? 'Sản phẩm'); ?></div>
                                <div class="small text-muted">Giá: <?php echo number_format($line, 0, ',', '.'); ?>đ</div>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <form class="update-cart-form d-flex align-items-center" onsubmit="return false;">
                                    <input type="hidden" name="product_id" value="<?php echo (int)($ci['product_id'] ?? 0); ?>">
                                    <input type="number" name="quantity" value="<?php echo (int)($ci['quantity'] ?? 0); ?>" min="1" class="form-control form-control-sm me-2" style="width:78px;">
                                    <button class="btn btn-sm btn-outline-secondary update-cart-btn" type="button" title="Cập nhật"><i class="fas fa-check"></i></button>
                                </form>
                                <form action="/phamgiahuy/product/removeFromCart" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo (int)($ci['product_id'] ?? 0); ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Xóa"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="p-3 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="small text-muted">Tổng</div>
                        <div class="fw-bold"><?php echo number_format($cartTotal, 0, ',', '.'); ?>đ</div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/phamgiahuy/product/checkout" class="btn btn-primary flex-grow-1">Thanh toán</a>
                        <a href="/phamgiahuy/product/cart" class="btn btn-glass">Xem giỏ</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
// AJAX update cart from offcanvas
document.addEventListener('DOMContentLoaded', function(){
    $(document).on('click', '.update-cart-btn', function(e){
        var $btn = $(this);
        var $form = $btn.closest('.update-cart-form');
        var product_id = $form.find('input[name="product_id"]').val();
        var quantity = $form.find('input[name="quantity"]').val();
        if (!product_id) return;
        $.post('/phamgiahuy/product/updateCart', { product_id: product_id, quantity: quantity })
            .done(function(res){
                // reload to refresh cart and totals
                location.reload();
            }).fail(function(){
                alert('Cập nhật giỏ hàng thất bại. Vui lòng thử lại.');
            });
    });
});
</script>
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
                    <a href="/phamgiahuy/product" class="list-group-item list-group-item-action <?php echo !isset($current_category) ? 'active' : ''; ?>">
                        <i class="fas fa-boxes me-2"></i>Tất cả
                    </a>
                    <?php foreach ($sidebarCategories as $category): ?>
                        <a href="/phamgiahuy/product/category/<?php echo $category->id; ?>" class="list-group-item list-group-item-action <?php echo (isset($current_category) && $current_category->id == $category->id) ? 'active' : ''; ?>">
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