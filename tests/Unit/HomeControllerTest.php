<?php

namespace Tests\Unit;

use App\Http\Controllers\HomeController;
use Mockery;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $home = Mockery::mock('App\Http\Controllers\HomeController');
        $contoller = new HomeController($home);

        $contoller->home();
        $home->shouldReceive('home')->once();
        $this->assertTrue(true);
    }
}
