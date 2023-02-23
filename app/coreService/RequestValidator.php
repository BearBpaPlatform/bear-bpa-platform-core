<?php


namespace SidorkinAlex\BearERP\coreService;


use Swoole\Http\Request;

class RequestValidator
{
    public function validationRequest(Request $request): bool
    {
        return (!empty($request->server['request_method']) && !empty($request->server['request_uri']));
    }

    public function hasAuth(Request $request): bool
    {
        return true;
    }

    public function needAuth(Request $request): bool
    {
        return true;
    }

}