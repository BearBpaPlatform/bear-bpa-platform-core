<?php


namespace SidorkinAlex\BearERP\Core\CoreControllers;


use DI\Container;
use Swoole\Http\Request;
use Swoole\Http\Response;

class AbstractController implements ControllerInterface
{
    protected URI $uri;

    public function __construct(URI $uri)
    {
        $this->uri = $uri;
    }

    public function callActionMethod(Container $container, string $method): Response
    {
        try {
            if (method_exists($this, 'pre_' . $method)) {
                $container->call([$this, 'pre_' . $method]);
            }
            $response = $container->call([$this,$method]);
            if (method_exists($this, 'post_' . $method)) {
                $container->set('Swoole\Http\Response',$response);
                $response =$container->call([$this, 'post_' . $method]);
            }
        } catch (\Exception $exception){
            $response = $container->get('Swoole\Http\Response');
            if($response instanceof Response){
                $response->setStatusCode(405);
                $response->write(json_encode(['status' => 'error', 'message'=> 'error']));
            }
        }
        return $response;
    }
}