<?php
require_once __DIR__ . '/../services/PostService.php';

// Dodaj wszystkie kontrolery
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/PostController.php';
require_once __DIR__ . '/../controllers/AccountController.php';

class Router {
    private $routes = [];

    public function addRoute($url, $handler) {
        $this->routes[$url] = $handler;
    }

    public function dispatch($url) {
        // Usuń początkowy slash i trailing slash
        $url = trim($url, '/');
        
        // Dodaj debugowanie
        // echo "Cleaned URL: " . $url . "<br>";
        // echo "Available routes: <pre>" . print_r($this->routes, true) . "</pre>";

        // Najpierw sprawdź dokładne dopasowanie
        if (isset($this->routes[$url])) {
            list($controllerName, $method) = explode('@', $this->routes[$url]);
            $this->callController($controllerName, $method);
            return;
        }

        // Jeśli nie znaleziono dokładnego dopasowania, sprawdź wzorce dynamiczne
        foreach ($this->routes as $route => $handler) {
            // Zamień parametry {id} na wyrażenie regularne
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            
            if (preg_match('/^' . $pattern . '$/', $url, $matches)) {
                array_shift($matches); // Usuń pełne dopasowanie
                list($controllerName, $method) = explode('@', $handler);
                $this->callController($controllerName, $method, $matches);
                return;
            }
        }

        // Jeśli nie znaleziono żadnego dopasowania
        header("HTTP/1.0 404 Not Found");
        echo "404 - Strona nie została znaleziona!";
    }

    private function callController($controllerName, $method, $params = []) {
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            
            // Inicjalizacja serwisów
            $postService = new PostService($controller);
            
            // Ustawienie zmiennych dla widoku
            global $postController, $postService;
            $postController = $controller;
            
            if (method_exists($controller, $method)) {
                if (!empty($params)) {
                    $controller->$method(...$params);
                } else {
                    $controller->$method();
                }
            } else {
                echo "Błąd: Metoda $method nie istnieje w kontrolerze $controllerName.";
            }
        } else {
            echo "Błąd: Kontroler $controllerName nie został znaleziony.";
        }
    }
}