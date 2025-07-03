<?php
    namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller;
    
    use PHPUnit\Framework\TestCase;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\Session;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\HomeController;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\SessionRepository;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
    use ProgrammerZamanNow\BElajar\PHP\MVC\Service\SessionService;
    
    class HomeControllerTest extends TestCase
    {
        private HomeController $homeController;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;

        protected function setUp(): void
        {
            $this->homeController = new HomeController();
            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->userRepository = new UserRepository(Database::getConnection());
            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();
        }

        public function testGuest()
        {
            ob_start();
            $this->homeController->index();
            $output = ob_get_clean();

            $this->assertStringContainsString('Login Management', $output);
        }

        public function testUserLogin()
        {
            $user = new User();
            $user->id = "eko";
            $user->name = "Eko";
            $user->password = "rahasia";
            $this->userRepository->save($user);;
            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);
            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;
            
            ob_start();
            $this->homeController->index();
            $output = ob_get_clean();

            $this->assertStringContainsString('Hello Eko', $output);
        }
    }