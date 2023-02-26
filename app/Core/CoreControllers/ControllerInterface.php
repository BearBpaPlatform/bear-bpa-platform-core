<?php


namespace SidorkinAlex\BearERP\Core\CoreControllers;


use DI\Container;
use Swoole\Http\Response;

interface ControllerInterface
{
    public function __construct(URI $uri);

    public function callActionMethod(Container $container, string $method): Response;

}