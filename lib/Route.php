<?php
 namespace Lib;
class Route
{
    private static $routes = [
        'GET' => [],
        'POST' => []
    ];
    public static function get($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$routes['GET'][$uri] = $callback;
    }
    public static function post($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri] = $callback;
    }
    public static function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');
        $uri = str_replace('calidad-financiera/public/', "", $uri); // Ajusta según tu entorno
        $method = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes[$method] as $routeUri => $callback) {
            if (strpos($routeUri, ':') !== false) {
                $routeUri = preg_replace('#:[a-zA-Z]+#', '([a-zA-Z0-9]+)', $routeUri);
            }
            if (preg_match("#^$routeUri$#", $uri, $matches)) {
                $params = array_slice($matches, 1);

                if (is_array($callback)) {
                    $controller = new $callback[0];
                    $response = $controller->{$callback[1]}(...$params);
                } elseif (is_callable($callback)) {
                    $response = $callback(...$params);
                } else {
                    throw new \Exception("Callback no válido");
                }
                if (is_array($response) || is_object($response)) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {
                    echo $response;
                }
                return;
            }
        }
        include '../resources/views/404.php';
        header("HTTP/1.0 404 Not Found");
    }


}
