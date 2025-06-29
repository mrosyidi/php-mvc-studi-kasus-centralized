<?php

    require_once __DIR__ . "/../vendor/autoload.php";

    use ProgrammerZamanNow\Belajar\PHP\MVC\App\Router;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\HomeController;

    Router::add('GET', '/', HomeController::class, 'index');
    Router::add('GET', '/hello', HomeController::class, 'login');
    Router::add('GET', '/world', HomeController::class, 'register');
    Router::run();