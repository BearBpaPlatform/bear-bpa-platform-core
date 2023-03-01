<?php


namespace SidorkinAlex\BearERP\Core\CoreControllers;


use Swoole\Http\Response;

class ErrorController extends AbstractController
{
    public function error(Response $response){
        $response->setStatusCode(404);
        return $response;
    }

}