<?php

    require_once __DIR__ . "/../vendor/autoload.php";

    use ProgrammerZamanNow\Belajar\PHP\MVC\App\Router;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\HomeController;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Middleware\AuthMiddleware;

    Router::add('GET', '/', HomeController::class, 'index', []);
    Router::run();