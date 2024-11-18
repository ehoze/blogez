<?php
class Router {
    private $routes = [];

    // Dodaje trasę do routera
    public function addRoute($route, $controllerAction) {
        // Zastępuje parametry w route, np. {id} -> (\d+)
        $routePattern = preg_replace('/\{(\w+)\}/', '(\w+)', $route);
        $this->routes[$routePattern] = $controllerAction;
    }

    // Przekierowanie na odpowiednią trasę na podstawie URL
    public function dispatch($url) {
        $url = trim(parse_url($url, PHP_URL_PATH), '/');

        foreach ($this->routes as $routePattern => $controllerAction) {
            // Sprawdzenie dopasowania URL do zdefiniowanej trasy
            if (preg_match("#^$routePattern$#", $url, $matches)) {
                array_shift($matches); // Usunięcie pełnego dopasowania

                // Rozdzielenie na kontroler i metodę
                list($controllerName, $method) = explode('@', $controllerAction);
                $this->callController($controllerName, $method, $matches);
                return;
            }
        }
        echo "404 - Strona nie została znaleziona!";
    }

    // Inicjuje kontroler i wywołuje metodę z opcjonalnymi parametrami
    private function callController($controllerName, $method, $params = []) {
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Błąd: Metoda $method nie istnieje w kontrolerze $controllerName.";
            }
        } else {
            echo "Błąd: Kontroler $controllerName nie został znaleziony.";
        }
    }
}









// class Router {
//     private $routes = [];

//     // Dodaje trasę do routera
//     public function addRoute($route, $controllerAction) {
//         $this->routes[$route] = $controllerAction;
//     }

//     // Przekierowanie na odpowiednią trasę na podstawie URL
//     public function dispatch($url) {
//         // Usuwamy prefiksy i dodatkowe znaki
//         $url = trim(parse_url($url, PHP_URL_PATH), '/');

//         if (array_key_exists($url, $this->routes)) {
//             list($controllerName, $method) = explode('@', $this->routes[$url]);
//             $this->callController($controllerName, $method);
//         } else {
//             echo "404 - Strona nie została znaleziona!";
//         }
//     }

//     // Inicjuje kontroler i wywołuje metodę
//     private function callController($controllerName, $method) {
//         if (class_exists($controllerName)) {
//             $controller = new $controllerName();
//             if (method_exists($controller, $method)) {
//                 $controller->$method();
//             } else {
//                 echo "Błąd: Metoda $method nie istnieje w kontrolerze $controllerName.";
//             }
//         } else {
//             echo "Błąd: Kontroler $controllerName nie został znaleziony.";
//         }
//     }
// }
?>
