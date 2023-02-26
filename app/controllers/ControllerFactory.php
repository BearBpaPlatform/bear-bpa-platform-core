<?php


namespace SidorkinAlex\BearERP\controllers;


use JetBrains\PhpStorm\Pure;
use SidorkinAlex\BearERP\coreService\RequestValidator;
use SidorkinAlex\BearERP\Utils\LogUtils;
use Swoole\Http\Request;

class ControllerFactory
{
    protected RequestValidator $requestValidator;
    protected string $method;

    /**
     * ControllerFactory constructor.
     * @param RequestValidator $requestValidator
     */
    public function __construct(RequestValidator $requestValidator)
    {
        $this->requestValidator = $requestValidator;
    }

    /**
     * @param Request $request
     * @param URI $uri
     * @return ControllerInterface
     */
    public function buildController(Request $request, URI $uri): ControllerInterface
    {
        if ($this->requestValidator->validationRequest($request)) {
            return $this->searchController($request, $uri);
        } else {
            //todo create error controller
        }
    }

    /**
     * @param Request $request
     * @param array $uri
     * @return
     */
    private function searchController(Request $request, URI $uri): ControllerInterface
    {
        if (!$this->requestValidator->needAuth($request)) {
            return new EntryPoint($uri);
        } elseif ($this->requestValidator->needAuth($request)) {
            return $this->selectControllerFromRoute($request, $uri);
        } else {
            $this->method = "error";
            return new ErrorController($uri);
        }
    }

    /**
     * @param Request $request
     * @param URI $uri
     * @return ControllerInterface
     */
    protected function selectControllerFromRoute(Request $request, URI $uri): ControllerInterface
    {
        if (!empty($uri->getModule())) {
            return $this->getModuleController($request, $uri);
        } elseif ($uri->getUriCollectionProperties(1) == 'api') {
            return $this->getAPIController($request);
        } else {
            $this->method = "error";
            return new ErrorController($uri);
        }
    }

    /**
     * @param Request $request
     * @param URI $uri
     * @return ControllerInterface
     */
    protected function getModuleController(Request $request, URI $uri): ControllerInterface
    {
        $className = "";
        $CustomControllerClassName = 'SidorkinAlex\BearERP\custom\modules\\' . $uri->getModule() . "\controller\Controller"; //Custom
        $ControllerClassName = 'SidorkinAlex\BearERP\modules\\' . $uri->getModule() . "\controller\Controller";
        $BaseControllerClassName = 'SidorkinAlex\BearERP\modules\\' . $uri->getModule() . "\controller\Controller";
        if (class_exists($CustomControllerClassName)) {
            $className = $CustomControllerClassName;
        } elseif (class_exists($ControllerClassName)) {
            $className = $ControllerClassName;
        } elseif (class_exists($BaseControllerClassName)) {
            $className = $BaseControllerClassName;
        }
        $this->method = "action_" . strtolower($request->getMethod()) . "_" . $uri->getAction();
        if (class_exists($className) && method_exists($className, $this->method)) {
            return new $className($uri);
        } else {
            $this->method = "error";
            return new ErrorController($uri);
        }
    }

    /**
     * @param Request $request
     * @return ControllerInterface
     */
    protected function getAPIController(Request $request): ControllerInterface
    {
        //todo make the method that create the API controller class
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

}