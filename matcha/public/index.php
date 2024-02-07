<?php

session_start();

require '../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as v;

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'mailer' => [
            'host' => 'maildev',
            'port' => 25,
            'user' => 'root@matcha.com',
            'pass' => '',
            'security' => null,
        ],
    ]
];

$app = new Slim\App($config);

require('../app/container.php');

$app->add(new App\Middleware\OldInputMiddleware($container));
$app->add(new App\Middleware\CsrfViewMiddleware($container));
$app->add(new App\Middleware\AuthMiddleware($container));
$app->add(new App\Middleware\ChatMiddleware($container));

$app->add($container->csrf);

/*** Routes ***/

$app->get('/', '\App\Controller\SignController:signView')->setName('signView');
$app->get('/registration', '\App\Controller\SignController:registerView')->setName('registerView');
$app->get('/home', '\App\Controller\HomeController:homeView')->setName('homeView');
$app->get('/search', '\App\Controller\SearchController:searchView')->setName('searchView');
$app->get('/logout', '\App\Controller\HomeController:logout')->setName('logOut');
$app->get('/profile/{username}', '\App\Controller\ProfileController:profileView')->setName('profile');
$app->get('/activation/{username}/{token}', '\App\Controller\SignController:activation')->setName('activation');
$app->get('/password-reset/{username}/{token}', '\App\Controller\SignController:resetView')->setName('resetView');
$app->get('/profile/{username}/like', '\App\Controller\ProfileController:likeAction')->setName('likeAction');
$app->get('/profile/{username}/unlike', '\App\Controller\ProfileController:unlikeAction')->setName('unlikeAction');
$app->get('/profile/{username}/block', '\App\Controller\ProfileController:blockAction')->setName('blockAction');
$app->get('/profile/{username}/unblock', '\App\Controller\ProfileController:unblockAction')->setName('unblockAction');
$app->get('/profile/{username}/fake', '\App\Controller\ProfileController:fakeAction')->setName('fakeAction');
$app->get('/profile/{username}/unfake', '\App\Controller\ProfileController:unfakeAction')->setName('unfakeAction');
$app->get('/stillAlive', '\App\Controller\GeneralController:connectedAction')->setName('stillAlive');
$app->get('/sort-by', '\App\Controller\HomeController:sortBy')->setName('sortBy');
$app->get('/stillConnected', '\App\Controller\GeneralController:stillConnectAction')->setName('stillConnected');
$app->get('/getMessages', '\App\Controller\ChatController::getMessagesAction')->setName('getMessages');
$app->get('/addMessage', '\App\Controller\ChatController::addMessageAction')->setName('addMessage');
$app->get('/newMessages', '\App\Controller\ChatController::newMessagesAction')->setName('newMessages');
$app->get('/readAll', '\App\Controller\ChatController::readAllAction')->setName('readAll');
$app->get('/getNotif', '\App\Controller\GeneralController::getNotifAction')->setName('getNotif');
$app->get('/countNotif', '\App\Controller\GeneralController:countNotifAction')->setName('countNotif');
$app->get('/readNotif', '\App\Controller\GeneralController:readNotifAction')->setName('readNotif');
$app->get('/homeFilter', '\App\Controller\HomeController:homeFilter')->setName('homeFilter');
$app->get('/searchFilter', '\App\Controller\SearchController:searchFilter')->setName('searchFilter');



$app->post('/signup', '\App\Controller\SignController:signup')->setName('signup');
$app->post('/signin', '\App\Controller\SignController:signin')->setName('signin');
$app->post('/register', '\App\Controller\SignController:registration')->setName('register');
$app->post('/password-reset', '\App\Controller\SignController:passwordReset')->setName('passwordReset');
$app->post('/password-reset/{username}/{token}', '\App\Controller\SignController:resetAction')->setName('resetAction');
$app->post('/resend-confirm', '\App\Controller\SignController:resendConfirm')->setName('resendConfirm');
$app->post('/profile/{username}/upd/profile', '\App\Controller\ProfileController:updateProfile')->setName('updateProfile');
$app->post('/profile/{username}/upd/info', '\App\Controller\ProfileController:updateInfo')->setName('updateInfo');
$app->post('/profile/{username}/upd/bio', '\App\Controller\ProfileController:updateBio')->setName('updateBio');
$app->post('/profile/{username}/upd/tag', '\App\Controller\ProfileController:updateTag')->setName('updateTag');
$app->post('/profile/{username}/insert/img', '\App\Controller\ProfileController:updateImg')->setName('insertImg');
$app->post('/profile/{username}/upd/img', '\App\Controller\ProfileController:updateImg')->setName('updateImg');

$app->run();
