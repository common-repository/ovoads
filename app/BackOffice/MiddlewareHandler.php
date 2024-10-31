<?php

namespace Ovoads\BackOffice;

class MiddlewareHandler{
    public function handle($assignedMiddleware = [])
    {
        foreach ($assignedMiddleware as $middleware) {
			if (array_key_exists($middleware,ovoads_system_instance()->middleware)) {
				$middlewareName = ovoads_system_instance()->middleware[$middleware];
				$this->callMiddleware($middlewareName);
			}
		}
    }

    public function filterGlobalMiddleware(){
		foreach (ovoads_system_instance()->globalMiddleware as $middleware) {
			$this->callMiddleware($middleware);
		}
	}

    private function callMiddleware($middleware)
	{
		$middlewareClass = new $middleware;
		$middlewareClass->filterRequest();
	}
}