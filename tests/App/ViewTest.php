<?php 

    namespace ProgrammerZamanNow\Belajar\PHP\MVC\App;

    use PHPUnit\Framework\TestCase;

    class ViewTest extends TestCase 
    {
        public function testRender()
        {
            ob_start();
            View::render("Home/index", ["title" => "PHP Login Management"]);
            $output = ob_get_clean();

            $this->assertStringContainsString('<title>PHP Login Management</title>', $output);
            $this->assertStringContainsString('<html', $output);
            $this->assertStringContainsString('<body', $output);
            $this->assertStringContainsString('Login Management', $output);
            $this->assertStringContainsString('Register', $output);
            $this->assertStringContainsString('Login', $output);
        }
    }