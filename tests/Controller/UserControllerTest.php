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
                $this->userController->postRegister();
                $this->expectOutputRegex("[Location: /users/login]");
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
        } 
    }