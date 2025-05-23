<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Định nghĩa đường dẫn gốc
// Lấy tên thư mục project từ đường dẫn thực tế

$projectFolder = basename(dirname(__DIR__));
define('ROOT_PATH', dirname(__DIR__));
define('ENVIRONMENT', 'development');

// Automatically detect the base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . '://' . $host . rtrim($scriptName, '/'));

// Update other URLs to use BASE_URL
define('PUBLIC_URL', BASE_URL);
define('ASSETS_URL', PUBLIC_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMAGES_URL', ASSETS_URL . '/images');
define('ADMIN_URL', PUBLIC_URL . '/admin');
define('DEBUG', true);

define('REQUIRE_EMAIL_VERIFICATION', true);

// Load CONSTANT FROM PERMISSION
require_once ROOT_PATH . '/app/config/Permission.php';

// Autoload classes từ Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Khởi tạo session
session_start();


// V2. Router
use App\Config\Router;

$router = new Router();

// Image Upload for Editor.js
$router->post('/upload-image', 'UploadController@uploadImage');
$router->post('/fetch-image', 'UploadController@fetchImage');


$router->get('/', 'HomeController@index');
$router->get('/home/about', 'HomeController@about');
$router->get('/home/contact', 'HomeController@contact');
$router->post('/home/contact', 'HomeController@contact');
$router->get('/home/faq', 'HomeController@faq');
$router->get('/home/privacy-policy', 'HomeController@privacyPolicy');
$router->get('/home/terms', 'HomeController@terms');
$router->get('/home/activities', 'HomeController@activities');

$router->get('/home/news', 'HomeController@news');
$router->get('/home/news-detail/{id}', 'HomeController@newsDetail');
$router->get('/home/tours', 'HomeController@tours');
$router->get('/home/home', 'HomeController@home');
$router->get('/home/search', 'HomeController@search');
$router->get('/home/tour-details/{id}', 'HomeController@tourDetail');
$router->get('/home/bookings/{id}', 'HomeController@bookings');

// PAYMENT PROCESSING
$router->get('/home/bookings/summary/{tourId}', 'HomeController@summary');
$router->post('/home/bookings/process', 'HomeController@process');
// Payment handling routes
$router->get('/payments/stripe/success/{bookingId}', 'HomeController@stripeSuccess');
$router->get('/payments/stripe/cancel/{bookingId}', 'HomeController@stripeCancel');
$router->get('/payment/process/{bookingId}', 'HomeController@processPayment');
// Webhook to receive Stripe events
$router->post('/webhook/stripe', 'WebhookController@handle');


// USERS
$router->get('/user/profile', 'UserController@profile');
$router->post('/user/profile', 'UserController@profile');
$router->get('/user/wishlist', 'UserController@favorite');
$router->post('/user/toggle', 'UserController@toggle');
$router->get('/user/bookings', 'UserController@userBookings');
$router->get('/user/bookings/detail/{bookingId}', 'HomeController@bookingDetail');
$router->get('/user/bookings/cancel/{bookingId}', 'HomeController@cancelBooking');
$router->post('/user/bookings/cancel/{bookingId}', 'HomeController@cancelBooking');
$router->get('/user/reviews', 'UserController@reviews');
$router->get('/user/change-password', 'UserController@changePassword');
$router->post('/user/change-password', 'UserController@changePassword');
$router->get('/user/deleteReview/{id}', 'UserController@deleteReview');
// Review routes
$router->get('/user/review/tour/{id}', 'UserController@reviewTour');
$router->post('/user/review/tour/{id}', 'UserController@submitReview');

// AUTH
$router->get('/auth/login', 'AuthController@login');
$router->post('/auth/login', 'AuthController@login');
$router->get('/auth/register', 'AuthController@register');
$router->post('/auth/register', 'AuthController@register');
$router->get('/auth/logout', 'AuthController@logout');
$router->get('/auth/verify-email', 'AuthController@verifyEmail');
$router->get('/auth/forgot-password', 'AuthController@forgotPassword');
$router->post('/auth/forgot-password', 'AuthController@forgotPassword');
$router->get('/auth/reset-password/{token}', 'AuthController@resetPassword');
$router->post('/auth/reset-password/{token}', 'AuthController@resetPassword');


// ADMIN
$router->get('/admin/dashboard', 'Admin\DashboardController@dashboard');

// ADMIN/USERS
$router->get('/admin/users/index', 'Admin\UserController@index');
$router->get('/admin/users/create', 'Admin\UserController@create'); // Admin\UserController || create
$router->post('/admin/users/create', 'Admin\UserController@create'); // Admin\UserController
$router->get('/admin/users/edit/{id}', 'Admin\UserController@edit');
$router->post('/admin/users/edit/{id}', 'Admin\UserController@edit');
$router->get('/admin/users/detail/{id}', 'Admin\UserController@detail');
$router->post('/admin/users/updateStatus', 'Admin\UserController@updateStatus');

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
$router->post('/admin/tours/editTour/{id}', 'Admin\ToursController@editTour');
$router->get('/admin/tours/deleteTour/{id}', 'Admin\ToursController@deleteTour');


//ADMIN/CATEGORIES/
$router->get('/admin/tours/categories', 'Admin\ToursController@categories');
$router->get('/admin/tours/createCategory', 'Admin\ToursController@createCategory');
$router->get('/admin/tours/updateCategory/{id}', 'Admin\ToursController@updateCategory');
$router->post('/admin/tours/updateCategory/{id}', 'Admin\ToursController@updateCategory');
$router->get('/admin/tours/deleteCategory/{id}', 'Admin\ToursController@deleteCategory');
$router->post('/admin/tours/deleteCategory/{id}', 'Admin\ToursController@deleteCategory');
$router->post('/admin/tours/createCategory', 'Admin\ToursController@createCategory');


//ADMIN/BOOKINGS
$router->get('/admin/bookings', 'Admin\ToursController@bookings');
$router->get('/admin/bookings/{id}', 'Admin\ToursController@bookingDetails');
$router->get('/admin/bookings/updateBooking/{id}', 'Admin\ToursController@updateBooking');
$router->post('/admin/bookings/updateStatus/{id}', 'Admin\ToursController@updateStatus');
$router->post('/admin/bookings/updatePaymentStatus', 'Admin\ToursController@updateBookingPayment');


// ADMIN/LOCATIONS
$router->get('/admin/locations', 'Admin\LocationController@index');
$router->get('/admin/locations/create', 'Admin\LocationController@create');
$router->post('/admin/locations/create', 'Admin\LocationController@create');
$router->get('/admin/locations/edit/{id}', 'Admin\LocationController@edit');
$router->get('/admin/locations/show/{id}', 'Admin\LocationController@show');
$router->post('/admin/locations/delete/{id}', 'Admin\LocationController@delete');
$router->post('/admin/locations/change-status/{id}', 'Admin\LocationController@changeStatus');

//ADMIN/NEWS//CATEGORIES
$router->get('/admin/news/categories', 'Admin\NewsController@categories');
$router->get('/admin/news/createCategory', 'Admin\NewsController@createCategory');
$router->post('/admin/news/store', 'Admin\NewsController@store');
$router->post('/admin/news/createCategory', 'Admin\NewsController@createCategory');
$router->get('/admin/news/updateCategory/{id}', 'Admin\NewsController@updateCategory');
$router->post('/admin/news/updateCategory/{id}', 'Admin\NewsController@updateCategory');
$router->get('/admin/news/deleteCategory/{id}', 'Admin\NewsController@deleteCategory');

//ADMIN/NEWS
$router->get('/admin/news/index', 'Admin\NewsController@index');
$router->get('/admin/news/createNews', 'Admin\NewsController@createByEditor');
$router->post('/admin/news/createNews', 'Admin\NewsController@createNews');
$router->post('/admin/news/deleteNews/{id}', 'Admin\NewsController@deleteNews');
$router->get('/admin/news/updateNews/{id}', 'Admin\NewsController@updateNews');
$router->post('/admin/news/updateNews/{id}', 'Admin\NewsController@updateNews');
$router->get('/admin/news/preview/{id}', 'Admin\NewsController@preview');
$router->post('/admin/news/publish/{id}', 'Admin\NewsController@publishNews');
$router->post('/admin/news/unpublish/{id}', 'Admin\NewsController@unpublishNews');


// ADMIN/CONTACT
$router->get('/admin/contacts', 'Admin\ContactController@index');
$router->get('/admin/contacts/view/{id}', 'Admin\ContactController@details');
$router->post('/admin/contacts/archive', 'Admin\ContactController@archive');
$router->get('/admin/contacts/reply/{id}', 'Admin\ContactController@reply');
$router->post('/admin/contacts/mark-read', 'Admin\ContactController@markRead');
$router->post('/admin/contacts/send-reply', 'Admin\ContactController@sendReply');


// ADMIN/REVIEWS
$router->get('/admin/reviews', 'Admin\ReviewController@index');
$router->get('/admin/reviews/reviewDetail/{id}', 'Admin\ReviewController@reviewDetail');
$router->get('/admin/reviews/deleteReview/{id}', 'Admin\ReviewController@deleteReview');
$router->post('/admin/reviews/updateStatus/{id}', 'Admin\ReviewController@updateStatus');


// ADMIN/SYSTEM
$router->get('/admin/system/activity-logs', 'Admin\DashboardController@activityLogs');


// ERROR
$router->get('/errors/404', 'ErrorController@notFound');
// Xử lý request
$router->dispatch();