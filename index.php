<?php
require_once 'app/helpers/SessionHelper.php';
SessionHelper::init();

require_once 'app/models/ProductModel.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Chuẩn hóa tên controller và action (không phân biệt hoa thường ở URL)
$routeController = isset($url[0]) && $url[0] != '' ? ucfirst(strtolower($url[0])) : 'Default';
$controllerName = $routeController . 'Controller';
$action = isset($url[1]) && $url[1] != '' ? strtolower($url[1]) : 'index';

// Kiểm tra phân quyền Admin tập trung
$adminControllers = ['CategoryController'];
$adminActions = [
    'ProductController' => ['add', 'save', 'edit', 'update', 'delete', 'manageorders', 'updateorderstatus']
];

$requiresAdmin = false;
if (in_array($controllerName, $adminControllers)) {
    $requiresAdmin = true;
} elseif (isset($adminActions[$controllerName]) && in_array($action, $adminActions[$controllerName])) {
    $requiresAdmin = true;
}

if ($requiresAdmin && !SessionHelper::isAdmin()) {
    header('Location: /phamgiahuy/Product');
    exit;
}

// Kiểm tra xem file controller có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    die('Controller not found');
}

require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();

// Kiểm tra xem action có tồn tại không
if (!method_exists($controller, $action)) {
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));