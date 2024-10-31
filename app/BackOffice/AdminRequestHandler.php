<?php

namespace Ovoads\BackOffice;

use Ovoads\BackOffice\Router\Router;
use Ovoads\Controllers\Admin\AdminController;
use Ovoads\Hook\ExecuteRouter;

class AdminRequestHandler
{
    public function handle()
    {
        if (ovoads_request()->page){
            if (!ovoads_request()->module) {
                
                $handler = new MiddlewareHandler();
                $handler->filterGlobalMiddleware();
                
                $routes = Router::$routes;
                foreach ($routes as $routeKey => $routeValue) {
                    foreach ($routeValue as $routerKey => $router) {
                        if (array_key_exists('query_string',$router)
                         && $router['query_string'] == ovoads_request()->page
                         ) {
                            if (array_key_exists('middleware', $router)) {
                                $middleware = $router['middleware'];
                                $handler->handle($middleware);
                            }
                            $controller = new $router['action'][0];
                            $method = $router['action'][1];
                            $controller->$method();
                        }
                    }
                }

            } else {
                $getActions = ExecuteRouter::executeAdminRouter();
                if (!empty($getActions)) {
                    $controller = new $getActions[0];
                    $method = $getActions[1];
                    $controller->$method();
                } else {
                    if (defined('WP_DEBUG') && true === WP_DEBUG) {
                        throw new \Exception("Something went wrong");
                    }
                }
            }
        }
    }
}
