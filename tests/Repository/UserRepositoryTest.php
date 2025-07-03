<?php   

    namespace ProgrammerZamanNow\belajar\PHP\MVC\Repository;

    use PHPUNit\Framework\TestCase;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
    use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;

    class UserRepositoryTest extends TestCase
    {
        private UserRepository $userRepository;

        protected function setUp(): void 
        {
            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userRepository->deleteAll();
        }

        public function testSaveSuccess()
        {
            $user = new User();
            $user->id = "eko";
            $user->name = "Eko";
            $user->password = "rahasia";
            $this->userRepository->save($user);
            $result = $this->userRepository->findById($user->id);
            self::assertEquals($user->id, $result->id);
            self::assertEquals($user->name, $result->name);
            self::assertEquals($user->password, $result->password);
        }

        public function testFindByIdNotFound()
        {
            $user = $this->userRepository->findByID("notfound");
            self::assertNull($user);
        }

         public function testUpdate()
        {
            $user = new User();
            $user->id = "eko";
            $user->name = "Eko";
            $user->password = "rahasia";
            $this->userRepository->save($user);
            $user->name = "Budi";
            $this->userRepository->update($user);
            $result = $this->userRepository->findById($user->id);
            self::assertEquals($user->id, $result->id);
            self::assertEquals($user->name, $result->name);
            self::assertEquals($user->password, $result->password);
        }
    }