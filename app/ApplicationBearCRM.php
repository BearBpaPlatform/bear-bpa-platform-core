<?php


namespace SidorkinAlex\BearERP;


use co;
use DI\Container;
use SidorkinAlex\BearERP\Core\CoreControllers\ControllerFactory;
use Swoole\Http\Request;
use Swoole\Http\Response;

class ApplicationBearCRM
{
    protected static Container $container;
    public function __construct()
    {
        self::$container = new Container();
    }

    public static function getDIController(): Container
    {
        return self::$container;
    }

    public function start(Request $request,Response $response){
        $this->bootstrap();
        self::getDIController()->set('Swoole\Http\Response',$response);
        self::getDIController()->set('Swoole\Http\Request',$request);
        $controller = self::getDIController()->call(['\SidorkinAlex\BearERP\Core\CoreControllers\ControllerFactory', 'buildController'],[$request]);
        Utils\LogUtils::log("controller",$controller);
        $method = self::getDIController()->call(['\SidorkinAlex\BearERP\Core\CoreControllers\ControllerFactory', 'getMethod'],[$request]);
        $response = $controller->callActionMethod(self::getDIController(),$method);
        $response->end("");
    }

    protected function bootstrap()
    {
    }

}