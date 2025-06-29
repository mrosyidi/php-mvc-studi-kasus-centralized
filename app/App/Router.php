<?php 

    namespace ProgrammerZamanNow\Belajar\PHP\MVC\App;

    class Router 
    {
        private static array $routes = [];

        public static function add(string $method, string $path, string $controller, string $function): void 
        {
            self::$routes[] = [
                'method' => $method,
                'path' => $path,
                'controller' => $controller,
                'function' => $function
            ];
        }

        public static function run(): void 
        {

        }
    }