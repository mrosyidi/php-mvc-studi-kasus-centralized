<?php

    namespace ProgrammerZamanNow\Belajar\PHP\MVC\Middleware
    {
        use PHPUnit\Framework\TestCase;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\Session;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\SessionRepository;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
        use ProgrammerZamanNow\Belajar\PHP\MVC\Service\SessionService;

        class MustNotLoginMiddlewareTest extends TestCase
        {
            private MustNotLoginMiddleware $middleware;
            private UserRepository $userRepository;
            private SessionRepository $sessionRepository;
            
            protected function setUp(): void
            {
                $this->middleware = new MustNotLoginMiddleware();
                putenv("mode=test");
                $this->userRepository = new UserRepository(Database::getConnection());
                $this->sessionRepository = new SessionRepository(Database::getConnection());
                $this->sessionRepository->deleteAll();
                $this->userRepository->deleteAll();
            }

            public function testBeforeGuest()
            {
                $this->middleware->before();
                $this->expectOutputString("");
            }

            public function testBeforeLoginUser()
            {
                $user = new User();
                $user->id = "eko";
                $user->name = "Eko";
                $user->password = "rahasia";
                $this->userRepository->save($user);
                $session = new Session();
                $session->id = uniqid();
                $session->userId = $user->id;
                $this->sessionRepository->save($session);
                $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

                ob_start();
                $this->middleware->before();
                $output = ob_get_clean();

                $this->assertStringContainsString('Location: /', $output);
            }
        }
    }