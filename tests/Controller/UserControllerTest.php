<?php
    namespace ProgrammerZamanNow\Belajar\PHP\MVC\App
    {
        function header(string $value)
        {
            echo $value;
        }
    }

    namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller
    {
        use PHPUnit\Framework\TestCase;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\UserController;

        class UserControllerTest extends TestCase
        {
            private UserController $userController;
            private UserRepository $userRepository;
            
            protected function setUp(): void
            {
                $this->userController = new UserController();
                $this->userRepository = new UserRepository(Database::getConnection());
                $this->userRepository->deleteAll();
                putenv("mode=test");
            }

            public function testRegister()
            {
                ob_start();
                $this->userController->register();
                $output = ob_get_clean();

                $this->assertStringContainsString('Register', $output);
                $this->assertStringContainsString('Id', $output);
                $this->assertStringContainsString('Name', $output);
                $this->assertStringContainsString('Password', $output);
                $this->assertStringContainsString('Register new User', $output);
            }

            public function testPostRegisterSuccess()
            {
                $_POST['id'] = 'eko';
                $_POST['name'] = 'Eko';
                $_POST['password'] = 'rahasia';

                ob_start();
                $this->userController->postRegister();
                $output = ob_get_clean();

                $this->assertStringContainsString('Location: /users/login', $output);
            }

            public function testPostRegisterValidationError()
            {
                $_POST['id'] = '';
                $_POST['name'] = 'Eko';
                $_POST['password'] = 'rahasia';

                ob_start();
                $this->userController->postRegister();
                $output = ob_get_clean();
                
                $this->assertStringContainsString('Register', $output);
                $this->assertStringContainsString('Id', $output);
                $this->assertStringContainsString('Name', $output);
                $this->assertStringContainsString('Password', $output);
                $this->assertStringContainsString('Id, Name, Password can not blank', $output);
            }

            public function testPostRegisterDuplicate()
            {
                $user = new User();
                $user->id = 'eko';
                $user->name = 'Eko';
                $user->password = 'rahasia';
                $this->userRepository->save($user);
                $_POST['id'] = 'eko';
                $_POST['name'] = 'Eko';
                $_POST['password'] = 'rahasia';

                ob_start();
                $this->userController->postRegister();
                $output = ob_get_clean();

                $this->assertStringContainsString('Register', $output);
                $this->assertStringContainsString('Id', $output);
                $this->assertStringContainsString('Name', $output);
                $this->assertStringContainsString('Password', $output);
                $this->assertStringContainsString('User Id already exists', $output);
            }

            public function testLogin()
            {
                ob_start();
                $this->userController->login();
                $output = ob_get_clean();

                $this->assertStringContainsString('Login user', $output);
                $this->assertStringContainsString('Id', $output);
                $this->assertStringContainsString('Password', $output);
            }

            public function testLoginSuccess()
            {
                $user = new User();
                $user->id = 'eko';
                $user->name = 'Eko';
                $user->password = password_hash('rahasia', PASSWORD_BCRYPT);
                $this->userRepository->save($user);
                $_POST['id'] = 'eko';
                $_POST['password'] = 'rahasia';

                ob_start();
                $this->userController->postLogin();
                $output = ob_get_clean();

                $this->assertStringContainsString('Location: /', $output);
            }

            public function testLoginValidationError()
            {
                $_POST['id'] = "";
                $_POST['password'] = "";
                
                ob_start();
                $this->userController->postLogin();
                $output = ob_get_clean();

                $this->assertStringContainsString('Login user', $output);
                $this->assertStringContainsString('Id', $output);
                $this->assertStringContainsString('Password', $output);
                $this->assertStringContainsString('Id, Password can not blank', $output);
            }

            public function testLoginUserNotFound()
            {
                $_POST['id'] = 'notfound';
                $_POST['password'] = 'notfound';

                ob_start();
                $this->userController->postLogin();
                $output = ob_get_clean();

                $this->assertStringContainsString('Login user', $output);
                $this->assertStringContainsString('Id', $output);
                $this->assertStringContainsString('Password', $output);
                $this->assertStringContainsString('Id or password is wrong', $output);
            }

            public function testLoginWrongPassword()
            {
                $user = new User();
                $user->id = 'eko';
                $user->name = 'Eko';
                $user->password = password_hash('rahasia', PASSWORD_BCRYPT);
                $this->userRepository->save($user);

                $_POST['id'] = 'eko';
                $_POST['password'] = 'notfound';

                ob_start();
                $this->userController->postLogin();
                $output = ob_get_clean();

                $this->assertStringContainsString('Login user', $output);
                $this->assertStringContainsString('Id', $output);
                $this->assertStringContainsString('Password', $output);
                $this->assertStringContainsString('Id or password is wrong', $output);
            }
        } 
    }