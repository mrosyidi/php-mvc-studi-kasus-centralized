<?php 

    namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller;

    class HomeController
    {
        function index(): void 
        {
            $model = [
                'title' => 'Belajar PHP MVC',
                'content' => 'Selamat belajar PHP MVC di Channel Programmer Zaman Now'
            ];

            require __DIR__ . '/../View/Home/index.php';
        }

        function hello(): void 
        {
            echo "HomeController.hello()";
        }

        function world(): void 
        {
            echo "HemeController.world()";
        }

        function about(): void 
        {
            echo "Author, Eko Kurniawan Khannedy";
        }

        function login(): void 
        {
            $request = [
                'username' => $_POST['username'],
                'password' => $_POST['password']
            ];

            $response = [
                'message' => 'Login sukses'
            ];
        }
    }