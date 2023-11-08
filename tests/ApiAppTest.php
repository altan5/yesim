<?php

namespace Altan\YesimTest\Model;

use Altan\YesimTest\ApiApp;
use Altan\YesimTest\Controller\ItemController;
use Altan\YesimTest\Tools\Auth\BearerAuth;
use Altan\YesimTest\View\JsonView;
use Exception;
use PHPUnit\Framework\TestCase;

class ApiAppTest extends TestCase
{
    private ApiApp $app;
    protected function setUp(): void
    {
        $this->app = new ApiApp();
        $this->app->initDatabase(
            $GLOBALS['PDO_DSN'],
            $GLOBALS['PDO_USERNAME'],
            $GLOBALS['PDO_PASSWORD']
        );
    }
    public function testInitDatabase()
    {
        $this->assertNull($this->app->initDatabase(
            $GLOBALS['PDO_DSN'],
            $GLOBALS['PDO_USERNAME'],
            $GLOBALS['PDO_PASSWORD']
        ));
        $this->expectException(Exception::class);
        $this->app->initDatabase(
            "wrong dsn",
            "usen name",
            "pasward"
        );
    }
    public function testGetAuth()
    {
        $this->assertInstanceOf(BearerAuth::class, $this->app->getAuth());
    }
    public function testGetController()
    {
        $this->assertInstanceOf(ItemController::class, $this->app->getController("item"));
    }
    public function testGetView()
    {
        $this->assertInstanceOf(JsonView::class, $this->app->getView("200", ["data"]));
    }
    protected function tearDown(): void
    {
    }
}
