<?php

// require_once __DIR__ . '/../config/config.php';
// require_once __DIR__ . '/../src/core/Router.php';
// require_once __DIR__ . '/../src/core/Database.php'; // Przykład


// include_once("./config/config.php");
// @require_once('./inc/header.php');

// require_once('controllers/AllControllers.php');

// $router = new Router();

// // Definiujemy trasy - używamy {id} dla dynamicznych tras

// // Strona główna
// $router->addRoute('blogez', 'HomeController@index');

// // Account
// $router->addRoute('blogez/konto', 'AccountController@index');
// $router->addRoute('blogez/konto/register', 'AccountController@register');
// $router->addRoute('blogez/konto/login', 'AccountController@login');
// $router->addRoute('blogez/konto/logout', 'AccountController@logout');

// // Account + Posts - dodawanie wpisów
// $router->addRoute('blogez/konto/post', 'AccountController@postcreate');
// $router->addRoute('blogez/konto/post/edit/{id}', 'AccountController@postedit');

// // Wpisy - dynamiczne trasy dla pojedynczego wpisu
// $router->addRoute('blogez/wpisy', 'PostController@index');
// $router->addRoute('blogez/wpis/{id}', 'PostController@single');  // Dynamiczny parametr {id}

// // Uruchomienie routera na podstawie aktualnego adresu URL
// $router->dispatch($_SERVER['REQUEST_URI']);

// @require_once('inc/footer.php');




// Podstawowe wymagane pliki
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/src/core/Router.php';
// require_once __DIR__ . '/../src/core/Database.php';

// Nagłówek strony
require_once __DIR__ . '/src/views/inc/header.php';

// Kontrolery
require_once __DIR__ . '/src/controllers/AllControllers.php';

$router = new Router();

// Definiujemy trasy - używamy {id} dla dynamicznych tras

// Strona główna
$router->addRoute('blogez2', 'HomeController@index');

// Wpisy
$router->addRoute('blogez2/wpisy', 'PostController@index');
$router->addRoute('blogez2/wpis/{id}', 'PostController@single');

// Account
$router->addRoute('blogez2/konto', 'AccountController@index');
$router->addRoute('blogez2/konto/register', 'AccountController@register');
$router->addRoute('blogez2/konto/login', 'AccountController@login');
$router->addRoute('blogez2/konto/logout', 'AccountController@logout');

// Zarządzanie postami
$router->addRoute('blogez2/konto/post/create', 'AccountController@postcreate');
$router->addRoute('blogez2/konto/post/edit/{id}', 'AccountController@postedit');
$router->addRoute('blogez2/konto/post/delete/{id}', 'AccountController@deletepost');

// Pobierz aktualny URL
$currentUrl = $_SERVER['REQUEST_URI'];
// Usuń parametry GET jeśli istnieją
$currentUrl = strtok($currentUrl, '?');
// Usuń początkowy i końcowy slash
$currentUrl = trim($currentUrl, '/');

// Dispatch do odpowiedniego kontrolera
$router->dispatch($currentUrl);

// Stopka strony
require_once __DIR__ . '/src/views/inc/footer.php';
