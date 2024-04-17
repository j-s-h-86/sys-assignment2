<?php
// globala initieringar !
require_once (dirname(__FILE__) . "/src/Utils/Router.php");

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/src/pages/index.php';
});

$router->addRoute('/viewProduct', function () {
    require __DIR__ . '/src/pages/viewProduct.php';
});

$router->addRoute('/viewPopular', function () {
    require (__DIR__ . '/src/pages/viewPopular.php');
});


$router->addRoute('/viewCategory', function () {
    require __DIR__ . '/src/pages/viewCategory.php';
});

$router->addRoute('/user/login', function () {
    require __DIR__ . '/src/pages/users/login.php';
});

$router->addRoute('/user/register', function () {
    require __DIR__ . '/src/pages/users/register.php';
});

// $router->addRoute('/input', function () {
//     require __DIR__ . '/pages/form.php';
// });

$router->dispatch();
?>