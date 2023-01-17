#!/usr/bin/env php
<?php

declare(strict_types=1);

use SidorkinAlex\BearERP\ApplicationBearCRM;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
$http = new Server("0.0.0.0", 9501);
$http->on(
    "start",
    function (Server $http) {
        echo "Swoole HTTP server is started.\n";
    }
);
$http->on(
    "request",
    function (Request $request, Response $response) {
        require_once "./vendor/autoload.php";
        $app = new ApplicationBearCRM();
        $app->start($request,$response);
    }
);

$http->start();
