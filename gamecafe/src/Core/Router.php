<?php
namespace App\Core;

class Router {
    private $routes = [];

    /**
     * * @param string 
     * @param string $path 
     * @param string $controller
     * @param string $action 
     */
    public function add($method, $path, $controller, $action) {
        $pathRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $path);
        $pathRegex = '#^' . $pathRegex . '$#';
        
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $pathRegex,
            'controller' => $controller,
            'action' => $action
        ];
    }

    /**
     * * @param string
     * @param string $method 
     */
    public function dispatch($uri, $method) {
        $uri = parse_url($uri, PHP_URL_PATH);

        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {

            if ($route['method'] === strtoupper($method) && preg_match($route['path'], $uri, $matches)) {
                
                array_shift($matches);

                $controllerName = $route['controller'];
                $action = $route['action'];

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    
                    if (method_exists($controller, $action)) {
                        call_user_func_array([$controller, $action], $matches);
                        return; 
                    }
                }
            }
        }

        $this->sendNotFound();
    }
        private function sendNotFound() {
        http_response_code(404);
        echo '
        <div style="font-family: sans-serif; text-align: center; margin-top: 100px; color: #333;">
            <h1 style="font-size: 4rem; margin-bottom: 10px;">🎲 404</h1>
            <h2>Page introuvable</h2>
            <p style="color: #666;">Désolé, cette page n\'existe pas au Aji L3bo Café !</p>
            <a href="/" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px;">Retour à l\'accueil</a>
        </div>
        ';
    }
}