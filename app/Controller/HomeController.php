<?php 

    namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller;

    use ProgrammerZamanNow\Belajar\PHP\MVC\App\View;

    class HomeController
    {
        function index(): void 
        {
            $model = [
                'title' => 'Belajar PHP MVC',
                'content' => 'Selamat belajar PHP MVC di Channel Programmer Zaman Now'
            ];

            View::render('Home/index', $model);
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