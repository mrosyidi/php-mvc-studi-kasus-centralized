<?php 

    namespace ProgrammerZamanNow\Belajar\PHP\MVC\Middleware;

    class AuthMiddleware implements Middleware 
    {
        function before(): void 
        {
            if(!isset($_SESSION['user']))
            {
                header('Location: /login');
                exit();
            }
        }
    }