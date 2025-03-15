<?php

// Định nghĩa đường dẫn gốc
// Lấy tên thư mục project từ đường dẫn thực tế

$projectFolder = basename(dirname(__DIR__));
define('ROOT_PATH', dirname(__DIR__));

// Cấu hình đường dẫn cơ sở
define('BASE_URL', '/' . $projectFolder);
define('PUBLIC_URL', BASE_URL . '/public');
define('ASSETS_URL', PUBLIC_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMAGES_URL', ASSETS_URL . '/images');
define('ADMIN_URL', PUBLIC_URL . '/admin');

define('REQUIRE_EMAIL_VERIFICATION', false);

// Load CONSTANT FROM PERMISSION
require_once ROOT_PATH . '/app/config/Permission.php';

// Autoload classes từ Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Khởi tạo session
session_start();

// Routing cơ bản
// require_once ROOT_PATH . '/app/config/App.php';
// $app = new \App\Config\App();
// $app->run();

// V2. Router
use App\Config\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/home/about', 'HomeController@about');
$router->get('/home/contact', 'HomeController@contact');
$router->get('/home/tours/{tourId}', 'HomeController@tourDetails');
$router->get('/home/news', 'HomeController@news');
$router->get('/home/tours', 'HomeController@tours');
$router->get('/home/home', 'HomeController@home');



// ERROR
$router->get('/error/404', 'ErrorController@notFound');

// AUTH
$router->get('/auth/login', 'AuthController@login');
$router->post('/auth/login', 'AuthController@login');
$router->get('/auth/register', 'AuthController@register');
$router->post('/auth/register', 'AuthController@register');
$router->get('/auth/logout', 'AuthController@logout');

// ADMIN
$router->get('/admin/dashboard', 'Admin\DashboardController@dashboard');

// ADMIN/USERS
$router->get('/admin/users', 'Admin\UserController@index');

// ADMIN/ROLES
$router->get('/admin/roles', 'Admin\RoleController@index');
$router->get('/admin/roles/create', 'Admin\RoleController@create');
$router->get('/admin/roles/{id}/permissions', 'Admin\RoleController@permissions');
$router->post('/admin/roles/{id}/permissions', 'Admin\RoleController@updatePermissions');
$router->get('/admin/roles/{id}/edit', 'Admin\RoleController@edit');

// Xử lý request
$router->dispatch();
