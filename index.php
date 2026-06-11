<?php
require_once 'app/helpers/SessionHelper.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/models/ProductModel.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// API Routing
if (isset($url[0]) && $url[0] === 'api') {
    header('Content-Type: application/json');

    $resource = $url[1] ?? '';
    $id = $url[2] ?? null;
    $method = $_SERVER['REQUEST_METHOD'];

    $apiControllers = [
        'product' => 'ProductApiController',
        'category' => 'CategoryApiController'
    ];

    $controllerClass = $apiControllers[$resource] ?? null;
    if (!$controllerClass) {
        http_response_code(404);
        echo json_encode(['error' => 'API endpoint not found']);
        exit;
    }

    require_once 'app/controllers/' . $controllerClass . '.php';
    $controller = new $controllerClass();

    switch ($resource) {
        case 'product':
            if ($method === 'GET') {
                $id ? $controller->show($id) : $controller->index();
            } elseif ($method === 'POST') {
                $controller->create();
            } elseif ($method === 'PUT') {
                $controller->update($id);
            } elseif ($method === 'DELETE') {
                $controller->delete($id);
            }
            break;
        case 'category':
            if ($method === 'GET') {
                $id ? $controller->show($id) : $controller->index();
            } elseif ($method === 'POST') {
                $controller->create();
            } elseif ($method === 'PUT') {
                $controller->update($id);
            } elseif ($method === 'DELETE') {
                $controller->delete($id);
            }
            break;
    }
    exit;
}

// API Docs - serve swagger.json
if (isset($url[0]) && $url[0] === 'api-docs') {
    header('Content-Type: application/json');
    $specFile = __DIR__ . '/frontend/public/swagger.json';
    if (file_exists($specFile)) {
        readfile($specFile);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Swagger spec not found']);
    }
    exit;
}

// Web Routing
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
    header('Location: /phamgiahuy/product');
    exit;
}

// Kiểm tra yêu cầu đăng nhập đối với một số chức năng (ví dụ: hồ sơ cá nhân)
$requiresLogin = false;
$loginActions = [
    'AccountController' => ['profile', 'updateprofile']
];
if (isset($loginActions[$controllerName]) && in_array($action, $loginActions[$controllerName])) {
    $requiresLogin = true;
}

if ($requiresLogin && !SessionHelper::isLoggedIn()) {
    header('Location: /phamgiahuy/account/login');
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