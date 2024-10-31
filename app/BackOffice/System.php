<?php

namespace Ovoads\BackOffice;

use Ovoads\BackOffice\Database\Database;
use Ovoads\BackOffice\Router\Router;
use Ovoads\Middleware\RegisterMiddleware;

class System {

    private static $instance = null;
    public $middleware;
    public $globalMiddleware;
    public $bindValue = [];

    public static $facades = [
        'db'=>Database::class,
        'session'=>Session::class
    ];

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function handleRequestThroughRouter()
    {
        require_once OVOADS_ROOT.'routes/web.php';
        require_once OVOADS_ROOT.'routes/admin.php';
        ovoads_system_instance()->bindValue('routes',Router::$routes);
    }

    public function bootMiddleware()
    {
        $registeredMiddleware = new RegisterMiddleware;
        $this->middleware = $registeredMiddleware->aliasMiddleware;
        $this->globalMiddleware = $registeredMiddleware->globalMiddleware;
    }

    public function bindValue($key,$value)
    {
        $this->bindValue[$key] = $value;
    }

    public function routes()
    {
        return $this->bindValue['routes'];
    }

    public function route($routeName)
    {
        $routes = $this->routes();
        $routeExists = false;
        foreach ($routes as $route) {
            if (array_key_exists($routeName,$route)) {
                $routeExists = true;
                return $route[$routeName];
            }
        }
        if (!$routeExists) {
            throw new \Exception(esc_html($routeName).' route not define');
        }
    }
}