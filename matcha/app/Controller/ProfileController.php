<?php

namespace App\Controller;

use App\Model\Connected;
use App\Model\Fake;
use App\Model\Like;
use App\Model\Notif;
use App\Model\Validator;
use App\Model\View;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\User;
use App\Model\Tag;
use Respect\Validation\Validator as v;


class ProfileController extends Controller
{
    public function profileView (Request $req, Response $res, $arg)
    {
        $flash = $this->flash->getMessages();

        $data = User::whereOne('username', '=', $arg['username']);

        if (empty($data['username']))
        {
            $this->flash->addMessage('danger', 'User doesn\'t exist');

            return $res->withRedirect('/home');
        }

        $sql = $this->pdo->select(['tag_id'])->from('user_tag')->where('user_id', '=', $data['id']);
        $r = $sql->execute();
        $tags = $r->fetchAll();

        $tag = [];
        foreach ($tags as $key => $v) {
            $sql = $this->pdo->select()->from('tag')->where('id', '=', $v['tag_id']);
            $r = $sql->execute();
            $t_name = $r->fetch();
            $tag[$key] = $t_name['name'];
        }

        if (strtolower($arg['username']) === strtolower($_SESSION['username'])) {
            $t = Tag::getAll();
            $allTags = [];
            foreach ($t as $i => $value) {
                $allTags[$i] = $value['name'];
            }
            $lastLike = Like::getLastLike($data['id']);
            $lastView = View::getLastView($data['id']);
            return $this->view->render($res, 'myprofile.html.twig', [
                'username' => $arg['username'],
                'head_name' => $arg['username'],
                'data' => $data,
                'tag' => $tag,
                'flash' => $flash,
                'lastLike' => $lastLike,
                'lastView' => $lastView,
                'alltags' => $allTags
            ]);
        } else {
            $like = Like::ifLiked($_SESSION['username'], $arg['username']);
            $block = User::countBlock($_SESSION['username'], $arg['username']);
            $connected = Connected::connected($arg['username']);
            $lastConnection = Connected::lastConnection($arg['username']);
            $fake = Fake::ifFake($_SESSION['username'], $arg['username']);
            $cuser = User::whereOne('username', '=', $_SESSION['username']);

            $dlike = Like::ifLiked($arg['username'], $_SESSION['username']);
            $ulike = Like::ifLiked($_SESSION['username'], $arg['username']);
            View::addView($_SESSION['username'], $arg['username']);
            Notif::addNotif($data['id'], $cuser['file_1'], ucwords($cuser['username']) . " visited your profile");

            return $this->view->render($res, 'profile.html.twig', [
                'username' => $arg['username'],
                'head_name' => $_SESSION['username'],
                'data' => $data,
                'tag' => $tag,
                'flash' => $flash,
                'like' => $like,
                'block' => $block,
                'connected' => $connected,
                'lastConnection' => $lastConnection['connect_date'],
                'likeu' => ($dlike >= 1) ? 1 : 0,
                'uconnected' => ($dlike >= true && $ulike >= true) ? 1 : 0,
                'fake' => ($fake >= 1) ? 1 : 0 ,
            ]);
        }
    }

    public function updateProfile (Request $req, Response $res, $arg)
    {
        $files = $req->getUploadedFiles();

        if (User::checkFile($files['file_1']) === false) {
            $this->flash->addMessage('file_error', 'Input must be a valid Image 2');
            return $res->withRedirect($_SERVER['HTTP_REFERER']);
        }

        User::updateProfile($arg['username'], $files);
        $this->flash->addMessage('success', 'Profile Image changed.');
        return $res->withRedirect($_SERVER['HTTP_REFERER']);
    }

    public function updateInfo (Request $req, Response $res, $arg)
    {
        $v = new Validator($this->flash, $req->getParams());

        $v->setInput('first_name')->noWhiteSpace()->notEmpty()->alpha()->length(3, 15);
        $v->setInput('last_name')->notEmpty()->alpha()->length(3, 15);
        $v->setInput('username')->noWhiteSpace()->notEmpty()->length(3, 15);
        $v->setInput('day')->notEmpty()->num();
        $v->setInput('month')->notEmpty()->num();
        $v->setInput('year')->notEmpty()->num();
        $v->setInput('email')->email()->notEmpty();
        $v->setInput('gender')->notEmpty()->num();
        $v->setInput('orient')->notEmpty()->num();
        $v->setInput('country')->notEmpty();
        $v->setInput('state')->notEmpty();
        $v->setInput('city')->notEmpty();
        $v->setInput('zip')->notEmpty()->num();

        if ($v->failed() || !User::legalAge($req->getParams(), $this)) {
            return $res->withRedirect($_SERVER['HTTP_REFERER']);
        }
        User::updateInfo($arg['username'], $req->getParams());
        $this->flash->addMessage('success', 'Info Updated.');

        return $res->withRedirect('/profile/'.$arg['username']);
    }

    public function updateBio (Request $req, Response $res, $arg)
    {
        $v = new Validator($this->flash, $req->getParams());

        $v->setInput('bio')->notEmpty();

        if ($v->failed()) {
            return  $res->withRedirect($_SERVER['HTTP_REFERER']);
        }
        User::updateBio($arg['username'], $req->getParam('bio'));
        $this->flash->addMessage('success', 'Bio Updated.');

        return $res->withRedirect($_SERVER['HTTP_REFERER']);
    }

    public function updateTag (Request $req, Response $res, $arg)
    {
        $tags = $req->getParam('tag');
        Tag::updateTag($arg['username'], $tags);

        return $res->withRedirect($_SERVER['HTTP_REFERER']);
    }

    public function updateImg (Request $req, Response $res, $arg)
    {
        $files = $req->getUploadedFiles();
        $i = 2;
        while ($i < 6) {
            if (isset($files['file_' . $i]) && !empty($files['file_' . $i])) {
                break ;
            }
            $i++;
        }
        User::updateImg($arg['username'], $files, $i);

        return $res->withRedirect($_SERVER['HTTP_REFERER']);
    }

    public function likeAction (Request $req, Response $res, $arg)
    {
        Like::addLike($_SESSION['username'], $arg['username']);
        User::updatePopularity($arg['username']);

        return 1;
    }

    public function unlikeAction (Request $req, Response $res, $arg)
    {
        Like::unlike($_SESSION['username'], $arg['username']);
        User::updatePopularity($arg['username']);
        $user = User::whereOne('username', '=', $arg['username']);
        $user1 = User::whereOne('username', '=', $_SESSION['username']);
        Notif::addNotif($user['id'], $user1['file_1'],ucwords($user1['username']) . " don't like you anymore");

        return 1;
    }

    public function blockAction (Request $req, Response $res, $arg)
    {
        $user1 = User::whereOne('username', '=', $_SESSION['username']);
        $user2 = User::whereOne('username', '=', $arg['username']);
        User::block($user1['id'], $user2['id']);

        return 1;
    }

    public function unblockAction (Request $req, Response $res, $arg)
    {
        $user1 = User::whereOne('username', '=', $_SESSION['username']);
        $user2 = User::whereOne('username', '=', $arg['username']);
        User::unblock($user1['id'], $user2['id']);

        return 1;
    }

    public function fakeAction (Request $req, Response $res, $arg)
    {
        $faker = User::whereOne('username', '=', $_SESSION['username']);
        $faked = User::whereOne('username', '=', $arg['username']);
        Fake::addFake($faker['id'], $faked['id']);

        return 1;
    }

    public function unfakeAction (Request $req, Response $res, $arg)
    {
        $faker = User::whereOne('username', '=', $_SESSION['username']);
        $faked = User::whereOne('username', '=', $arg['username']);
        Fake::unFake($faker['id'], $faked['id']);

        return 1;
    }
}