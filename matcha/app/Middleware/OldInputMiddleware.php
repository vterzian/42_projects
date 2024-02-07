<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class OldInputMiddleware extends Middleware
{
    public function __invoke (Request $req, Response $res, $next)
    {
        $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $req->getParams();

        return $res = $next($req, $res);
    }
}
