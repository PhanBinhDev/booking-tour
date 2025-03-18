<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


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
define('DEBUG', true);

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
$router->get('/home/faq', 'HomeController@faq');
$router->get('/home/privacy-policy', 'HomeController@privacyPolicy');
$router->get('/home/terms', 'HomeController@terms');
$router->get('/home/activities', 'HomeController@activities');

$router->get('/home/tours/{tourId}', 'HomeController@tourDetails');
$router->get('/home/news', 'HomeController@news');
$router->get('/home/tours', 'HomeController@tours');
$router->get('/home/home', 'HomeController@home');
$router->get('/home/tour-details/{id}', 'HomeController@tourDetail');


// USERS
$router->get('/user/profile', 'UserController@profile');
$router->get('/user/bookings', 'UserController@userBookings');
$router->get('/user/change-password', 'UserController@changePassword');

// AUTH
$router->get('/auth/login', 'AuthController@login');
$router->post('/auth/login', 'AuthController@login');
$router->get('/auth/register', 'AuthController@register');
$router->post('/auth/register', 'AuthController@register');
$router->get('/auth/logout', 'AuthController@logout');
$router->get('/auth/forgot-password', 'AuthController@forgotPassword');

// ADMIN
$router->get('/admin/dashboard', 'Admin\DashboardController@dashboard');

// ADMIN/USERS
$router->get('/admin/users', 'Admin\UserController@index');
$router->get('/admin/users/create', 'Admin\UserController@create'); // Admin\UserController || create
$router->post('/admin/users/create', 'Admin\UserController@create'); // Admin\UserController
$router->get('/admin/users/edit/{id}', 'Admin\UserController@edit');
$router->post('/admin/users/edit/{id}', 'Admin\UserController@edit');

// ADMIN/ROLES
$router->get('/admin/roles', 'Admin\RoleController@index');
$router->get('/admin/roles/create', 'Admin\RoleController@create');
$router->get('/admin/roles/{id}/permissions', 'Admin\RoleController@permissions');
$router->post('/admin/roles/{id}/permissions', 'Admin\RoleController@updatePermissions');
$router->get('/admin/roles/{id}/edit', 'Admin\RoleController@edit');

// ADMIN/GALLERY
$router->get('/admin/images', 'Admin\ImageController@index');
$router->post('/admin/images', 'Admin\ImageController@upload');
$router->get('/admin/images/{id}', 'Admin\ImageController@details');
$router->get('/admin/images/edit/{id}', 'Admin\ImageController@edit');
$router->post('/admin/images/update/{id}', 'Admin\ImageController@update');
$router->get('/admin/images/delete/{id}', 'Admin\ImageController@delete');

// ADMIN/PAYMENT/METHODS
$router->get('/admin/payment/methods', 'Admin\PaymentController@methods');
$router->get('/admin/payment/methods/create', 'Admin\PaymentController@createMethod');
$router->post('/admin/payment/methods/create', 'Admin\PaymentController@createMethod');
$router->get('/admin/payment/methods/edit/{id}', 'Admin\PaymentController@editMethod');
$router->post('/admin/payment/methods/edit/{id}', 'Admin\PaymentController@editMethod');
$router->post('/admin/payment/methods/toggle/{id}', 'Admin\PaymentController@toggleMethod');


// ADMIN/PAYMENT/TRANSACTIONS
$router->get('/admin/payment/transactions', 'Admin\TransactionController@index');
$router->get('/admin/payment/transactions/{id}', 'Admin\TransactionController@show');

// ADMIN/PAYMENT/INVOICES
$router->get('/admin/payment/invoices', 'Admin\InvoiceController@index');
$router->get('/admin/payment/invoices/{id}', 'Admin\InvoiceController@show');
$router->get('/admin/payment/invoices/print/{id}', 'Admin\InvoiceController@printInvoice');


// ADMIN/PAYMENTS/REFUNDS
$router->get('/admin/payment/refunds', 'Admin\RefundController@index');
$router->get('/admin/payment/refunds/{id}', 'Admin\RefundController@show');


// ADMIN/TOURS/
$router->get('/admin/tours', 'Admin\ToursController@index');
$router->get('/admin/tours/createTour', 'Admin\ToursController@createTour');
$router->post('/admin/tours/createTour', 'Admin\ToursController@createTour');
$router->get('/admin/tours/editTour/{id}', 'Admin\ToursController@editTour');

//ADMIN/CATEGORIES/
$router->get('/admin/tours/categories', 'Admin\ToursController@categories');
$router->get('/admin/tours/createCategory', 'Admin\ToursController@createCategory');
$router->post('/admin/tours/createCategory', 'Admin\ToursController@createCategory');
$router->get('/admin/tours/categories/deleteCategory/{id}', 'Admin\ToursController@deleteCategory');
$router->get('/admin/tours/categories/updateCategory/{id}', 'Admin\ToursController@updateCategory');
$router->post('/admin/tours/categories/updateCategory/{id}', 'Admin\ToursController@updateCategory');


//ADMIN/BOOKINGS
$router->get('/admin/bookings', 'Admin\ToursController@bookings');
$router->get('/admin/bookings/deleteBooking/{id}', 'Admin\ToursController@deleteBooking');


// ADMIN/SYSTEM
$router->get('/admin/system/activity-logs', 'Admin\DashboardController@activityLogs');


// ERROR
$router->get('/errors/404', 'ErrorController@notFound');
// Xử lý request
$router->dispatch();
