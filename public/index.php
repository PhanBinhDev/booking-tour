<?php
// Định nghĩa đường dẫn gốc
// Lấy tên thư mục project từ đường dẫn thực tế

$projectFolder = basename(dirname(__DIR__));
define('ROOT_PATH', dirname(__DIR__));

// Cấu hình đường dẫn cơ sở
define('BASE_URL', '/'. $projectFolder);
define('PUBLIC_URL', BASE_URL . '/public');
define('ASSETS_URL', PUBLIC_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMAGES_URL', ASSETS_URL . '/images');
define('REQUIRE_EMAIL_VERIFICATION', false);

// Autoload classes từ Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Khởi tạo session
session_start();

// Routing cơ bản
require_once ROOT_PATH . '/app/config/App.php';
$app = new \App\Config\App();
$app->run();