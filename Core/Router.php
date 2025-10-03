<?php
class Router {
    private $routes = [];

    public function get(string $path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method) {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func($handler, ...array_values($params));
            }
        }

        // fallback: 404
        http_response_code(404);
        echo "404 Not Found: " . $path;
    }
}
