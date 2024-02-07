<?php

namespace App\Middleware;

use App\Model\Chat;
use Slim\Http\Request;
use Slim\Http\Response;

class ChatMiddleware extends Middleware
{
    public function __invoke (Request $req, Response $res, $next)
    {
        $data = Chat::getAllConnection();
        $this->container->view->getEnvironment()->addGlobal('connectedWith', $data);

        return $res = $next($req, $res);
    }
}