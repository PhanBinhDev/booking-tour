<?php

namespace App\Config;

use App\Controllers\BaseController;

class Router extends BaseController
{
    protected $routes = [];
    protected $notFoundCallback;

    /**
     * Thêm route GET
     */
    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
        return $this;
    }

    /**
     * Thêm route POST
     */
    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
        return $this;
    }

    /**
     * Thêm route với method bất kỳ
     */
    public function addRoute($method, $path, $callback)
    {
        // Chuyển đổi các tham số động {param} thành biểu thức chính quy
        $pattern = $this->convertPathToRegex($path);

        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'pattern' => $pattern,
            'callback' => $callback
        ];

        return $this;
    }

    /**
     * Xử lý khi không tìm thấy route
     */
    public function notFound($callback)
    {
        $this->notFoundCallback = $callback;
        return $this;
    }

    /**
     * Chuyển đổi path thành biểu thức chính quy
     */
    protected function convertPathToRegex($path)
    {
        // Thay thế {param} bằng biểu thức chính quy để bắt tham số
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);

        // Thêm dấu ^ và $ để đảm bảo khớp toàn bộ chuỗi
        $pattern = '#^' . $pattern . '$#';

        return $pattern;
    }

    /**
     * Xử lý request
     */
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getUri();


        foreach ($this->routes as $route) {
            // Kiểm tra method

            if ($route['method'] !== $method) {
                continue;
            }

            // Kiểm tra URI có khớp với pattern không
            if (preg_match($route['pattern'], $uri, $matches)) {
                // Lọc các tham số
                $params = array_filter($matches, function ($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                // Gọi callback với các tham số
                if (is_callable($route['callback'])) {
                    return call_user_func_array($route['callback'], $params);
                } else if (is_string($route['callback'])) {
                    // Xử lý callback dạng 'Controller@method'
                    list($controller, $method) = explode('@', $route['callback']);
                    $controllerClass = '\\App\\Controllers\\' . $controller;
                    $controllerInstance = new $controllerClass();
                    return call_user_func_array([$controllerInstance, $method], $params);
                }
            }
        }

        // Không tìm thấy route
        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }
        $this->view('error/404');
    }

    /**
     * Lấy URI hiện tại
     */
    protected function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Loại bỏ query string
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

        return '/' . trim($uri, '/');
    }
}
