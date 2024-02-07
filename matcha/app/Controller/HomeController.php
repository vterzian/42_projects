<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Tag;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends Controller
{
    public function homeView (Request $req, Response $res)
    {
        $flash = $this->flash->getMessages();
        $user = User::whereOne('username', '=', $_SESSION['username']);
        $tags = Tag::getAll();
        $match = User::match($_SESSION['username']);
        $match = User::delBlockedUser($match, $user['id']);

        return $this->view->render($res, 'home.html.twig', ['head_name' => $_SESSION['username'], 'match' => array_values($match), 'flash' => $flash, 'tags' => $tags]);
    }

    public function homeFilter (Request $req, Response $res)
    {
        $param = $req->getParams();
        $cat = ['popularity' => 'score', "localisation" => 'zip', 'age' => 'birthdate', 'common_tags' => 'commonTags'];

        $user = User::whereOne('username', '=', $_SESSION['username']);
        $match = User::match($_SESSION['username']);
        $match = array_values(User::delBlockedUser($match, $user['id']));
        $match = array_values(User::homeFilter($match, $param));

        $col = NULL;
        foreach ($cat as $key => $c) {
            if ($key === $param['orderBy'] ) {
                $col = $c;
            }
        }

        $i = 0;
        while ($match[$i]) {
            $match[$i]['age'] = User::birthdateToAge($match[$i]['birthdate']);
            if ($match[$i][$col] < $match[$i + 1][$col]) {
                $tmp = $match[$i];
                $match[$i] = $match[$i + 1];
                $match[$i + 1] =  $tmp;
                $i = -1;
            }
            ++$i;
        }

        return json_encode($match);
    }

    public function logout (Request $req, Response $res)
    {
        unset($_SESSION['username']);
        unset($_SESSION['active']);
        unset($_SESSION['register']);
        unset($_COOKIE['username']);
        setcookie('username', null, -1, '/');

        return $res->withRedirect('/');
    }
}