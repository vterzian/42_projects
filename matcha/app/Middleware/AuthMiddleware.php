<?php

namespace App\Middleware;

use App\Model\User;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware extends Middleware
{
    public function __invoke (Request $req, Response $res, $next)
    {
        $rout = $req->getAttribute('route');
        $route = $rout->getName();
        $allow = ['signView', 'signup', 'signin', 'activation', 'passwordReset', 'resetView', 'resetAction', 'resendConfirm'];
        if ($rout !== NULL) {
            if (!in_array($route, $allow)) {
                if ((!isset($_SESSION['username']) || empty($_SESSION['username']))) {
                    if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])) {
                        $_SESSION['username'] = $_COOKIE['username'];
                    } else {
                        $this->container->flash->addMessage('danger', 'Please Login before access this page.');

                        return $res->withRedirect('/');
                    }
                }
                if ($req->getAttribute('route') !== '/' && (!isset($_SESSION['active'], $_SESSION['register']) || (empty($_SESSION['active']) || empty($_SESSION['register'])))) {
                    $user = User::whereOne('username', '=', $_SESSION['username']);
                    $_SESSION['active'] = $user['active'];
                    $_SESSION['register'] = $user['register'];
                }
                if ($route === 'registerView') {
                    if ($_SESSION['active'] != '1') {
                        $this->container->flash->addMessage('danger', 'Please confirm your email before access this page.');

                        return $res->withRedirect('/');
                    } elseif ($_SESSION['register'] == '1') {
                        return $res->withRedirect('/home');
                    }
                }
            }
        }
        if ($route === 'signView') {
            if ((!isset($_SESSION['username']) || empty($_SESSION['username']))) {
                if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])) {
                    $_SESSION['username'] = $_COOKIE['username'];

                    return $res->withRedirect('/home');
                }
            }
            if ($_SESSION['active'] == '1' && !empty($_SESSION['username'])) {
                if ($_SESSION['register'] == 1) {

                    return $res->withRedirect('/home');
                }
                return $res->withRedirect('/registration');
            }
        }

        return $res = $next($req, $res);
    }
}