<?php

    require_once __DIR__ . "/../vendor/autoload.php";

    use ProgrammerZamanNow\Belajar\PHP\MVC\App\Router;

    Router::add('GET', '/', 'HomeController', 'index');
    Router::add('GET', '/login', 'UserController', 'login');
    Router::add('GET', '/register', 'UserController', 'register');
    Router::run();