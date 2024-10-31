<?php

namespace Ovoads\BackOffice\Router;

use Ovoads\BackOffice\MiddlewareHandler;

class Router{
    private static $nomatch = true;
	public static $currentUri = '';
	public static $routes = [];
	public static $mainRouter;
	public static $originalUri;
	public static $middlewareData = [];

	public static function getOriginalUri(){
		$projectPath = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
		$uri = sanitize_url($_SERVER['REQUEST_URI']);
		$uri = str_replace($projectPath, '/', $uri);
		return $uri;
	}

	private static function matches($pattern){
		$oroginalUrl = $pattern;
		$regx = '/\{.*?\}/';
		$paramMatch = preg_match($regx,$pattern);
		if ($paramMatch) {
			$pattern = preg_replace($regx,'(\w+)',$pattern);
		}
		$uri = wp_parse_url(self::getOriginalUri())['path'];
		$pattern = "~^/?{$pattern}/?$~";
		if(preg_match($pattern, $uri, $matches)){
			self::$currentUri = $oroginalUrl;
			return $matches;
		}
		return false;

	}

	public function cleanUp()
	{
		if (self::$nomatch) {
			echo "No match";
		}
	}

	public static function handleRouter($parentRouter,$childRouter,$uri,$action)
	{
		$pattern = $uri;
		$callback = $action;
		$params = self::matches($pattern);
		if ($params) {
			self::filterMiddleware(self::$middlewareData);
			$arguments = array_slice($params, 1);
			self::$nomatch = false;
			if(is_callable($callback)){
				$callback(...$arguments);
			}else{
				$controller = $callback[0];
				$method = $callback[1];
				$controllerInstance = $controller;
				$controllerInstance->$method(...$arguments);
			}
		}
	}

	public function router($data)
	{
		self::$routes[] = $data;
	}

	public function execute()
	{
		ovoads_system_instance()->bindValue('routes',self::$routes);
		foreach (self::$routes as $route) {
			$name = array_key_last($route);
			$router = $route[$name];
			self::$mainRouter = $router;
			if (!array_key_exists('sidebar_menu',$router)) {
				$this->uriAction($router,$router['uri'] ?? '');
			}
		}
	}

	private function uriAction($router,$uri){
		if (array_key_exists('middleware',$router)) {
			self::$middlewareData[] = $router['middleware'];
		}
		$uri = self::$originalUri.$router['uri'];
		$action = $router['action'];
		self::handleRouter(self::$mainRouter,$router,$uri,$action);
		
	}

    private static function filterMiddleware($middlewareData)
    {
        $handler = new MiddlewareHandler();
        $handler->handle($middlewareData);
    }
}