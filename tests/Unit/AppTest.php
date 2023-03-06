<?php


namespace Tests\Unit;

use DI\Container;
use SidorkinAlex\BearERP\ApplicationBearCRM;
use Tests\Support\UnitTester;

class AppTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testApplicationBearCRMGetDI()
    {
        $app = new ApplicationBearCRM();
        $this->assertEqualsCanonicalizing(true,($app::getDIController() instanceof Container),"first test");
    }
}
