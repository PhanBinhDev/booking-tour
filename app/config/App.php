<?php
namespace App\Config;

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Xác định controller
        if(isset($url[0]) && file_exists(ROOT_PATH . '/app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }
        
        // Khởi tạo controller
        $controllerClass = '\\App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClass();
        
        // Xác định method
        if(isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }
        
        // Xác định params
        $this->params = $url ? array_values($url) : [];
    }
    
    public function run() {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    protected function parseUrl() {
        // Lấy URL từ $_GET['url'] hoặc từ $_SERVER['REQUEST_URI']
        if(isset($_GET['url'])) {
            // Đã được xử lý bởi .htaccess
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        } else {
            // Lấy URI từ REQUEST_URI nếu không có $_GET['url']
            $uri = $_SERVER['REQUEST_URI'];
            
            // Loại bỏ query string nếu có
            if (($pos = strpos($uri, '?')) !== false) {
                $uri = substr($uri, 0, $pos);
            }
            
            // Lấy base path của dự án
            $projectFolder = basename(ROOT_PATH);
            $basePath = "/{$projectFolder}/public/";
            
            // Loại bỏ base path
            if (strpos($uri, $basePath) === 0) {
                $uri = substr($uri, strlen($basePath));
            }
            
            // Nếu rỗng thì trả về mảng rỗng
            if (empty($uri)) {
                return [];
            }
            
            // Phân tách URI thành mảng
            return explode('/', filter_var(rtrim($uri, '/'), FILTER_SANITIZE_URL));
        }
    }
}