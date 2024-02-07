<?php

$container = $app->getContainer();

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../view', [
        'debug' => true,
        'cache' => false
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    $ucwords = new Twig_SimpleFilter('ucwords', function ($string) {
        return ucwords($string);
    });

    $age = new Twig_SimpleFilter('age', function ($date) {
        $ret = new \DateTime($date);
        $today = new \DateTime('today');
        return $ret->diff($today)->y;
    });

    $day = new Twig_SimpleFilter('day', function ($date) {
        $ret = new \DateTime($date);
        return $ret->format('d');
    });

    $month = new Twig_SimpleFilter('month', function ($date) {
        $ret = new \DateTime($date);
        return $ret->format('m');
    });

    $year = new Twig_SimpleFilter('year', function ($date) {
        $ret = new \Datetime($date);
        return $ret->format('Y');
    });

    $lastConnection = new Twig_SimpleFilter('lastConnection', function ($date) {
        $today = new \DateTime('now');
        $ret = new \DateTime($date);

        if ((array)($v = $ret->diff($today)) > (array)new \DateInterval('P1Y')) {
            return ($v->y > 1) ? $v->y . " years" : $v->y . " year";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('P1M')) {
            return ($v->m > 1) ? $v->m . " months" : $v->m . " month";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('P1D')) {
            return ($v->d > 1) ? $v->d . " days" : $v->d . " day";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('PT1H')) {
            return ($v->h > 1) ? $v->h . " hours" : $v->h . " hour";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('PT1M')) {
            return ($v->i > 1) ? $v->i . " minutes" : $v->i . " minute";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('PT1S')) {
            return ($v->s > 1) ? $v->s . " secondes" : $v->s . " seconde";
        }


        return "Some time";
    });

    $view->getEnvironment()->addFilter($ucwords);
    $view->getEnvironment()->addFilter($age);
    $view->getEnvironment()->addFilter($day);
    $view->getEnvironment()->addFilter($month);
    $view->getEnvironment()->addFilter($year);
    $view->getEnvironment()->addFilter($lastConnection);

    return $view;
};

$container['pdo'] = function () {
    return \App\Model\Pdo::getInstance()->getDb();
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['mailer'] = function ($container) {
    $settings = $container->get('settings');

    $host = $settings['mailer']['host'] ?: 'localhost';
    $port = $settings['mailer']['port'] ?: 1025;
    $user = $settings['mailer']['user'] ?: 'root';
    $pass = $settings['mailer']['pass'] ?: '' ;
    $security = $settings['mailer']['security'] ?: null;

    return new Swift_Mailer(
        (new Swift_SmtpTransport($host, $port, $security))
            ->setUsername($user)
            ->setPassword($pass)
    );
};

$container['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard();
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        if (false === $request->getAttribute('csrf_status')) {
            $flash = new \Slim\Flash\Messages();
            $flash->addMessage('danger', 'Forme timed out, please reload your page !');
            return $response->withRedirect($_SERVER['HTTP_REFERER']);
        } else {
            return $next($request, $response);
        }
    });

    return $guard;
};