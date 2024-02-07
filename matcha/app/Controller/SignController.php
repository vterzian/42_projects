<?php

namespace App\Controller;

session_start();

use App\Model\Tag;
use App\Model\User;
use App\Model\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class SignController extends Controller
{
    public function signView(Request $req, Response $res)
    {
        $flash = $this->flash->getMessages();

        return $this->view->render($res, 'sign.html.twig', ['flash' => $flash]);
    }

    public function resetView(Request $req, Response $res, $arg)
    {
        $date = new \DateTime('now');
        $user = User::whereOne('token', '=', $arg['token']);
        $token_date = new \DateTime($user['token_date']);

        if (empty($user) || (array)$date->diff($token_date) > (array) new \DateInterval('PT30M')) {
            $flash = $this->flash->addMessage('danger', (empty($user)) ? 'No user found !' : 'Email expired !');

            return $res->withRedirect('/');
        }
        $flash = $this->flash->getMessages();

        return $this->view->render($res, 'reset.html.twig', [
            'flash' => $flash,
            'username' => $arg['username'],
            'token' => $arg['token'],
        ]);
    }

    public function registerView(Request $req, Response $res)
    {
        $flash = $this->flash->getMessages();
        $tags = Tag::getAll();
        $tag = [];
        foreach ($tags as $i => $t) {
            $tag[$i] = $t['name'];
        }

        return $this->view->render($res, 'register.html.twig', ['flash' => $flash, 'alltags' => $tag]);
    }

    public function signup(Request $req, Response $res)
    {
        $v = new Validator($this->container->flash, $req->getParams());

        $v->setInput('first_name')->noWhiteSpace()->notEmpty()->alpha()->length(3, 15);
        $v->setInput('last_name')->notEmpty()->alpha()->length(3, 15);
        $v->setInput('username')->noWhiteSpace()->notEmpty()->length(3, 15)->usernameAvailable();
        $v->setInput('email')->email()->notEmpty();
        $v->setInput('password')->noWhiteSpace()->notEmpty()->password();
        $v->setInput('confirmation')->noWhiteSpace()->notEmpty()->equals($req->getParam('password'));

        if ($v->failed()) {
            return $res->withRedirect('/');
        }

        $d = $req->getParams();
        $token = md5(microtime(TRUE) * 100000);
        if (User::create(
                $d['first_name'],
                $d['last_name'],
                $d['username'],
                $d['email'],
                $d['password'],
                $token
            ) === false) {
            $this->flash->addMessage('danger', 'An error occured during registration');

            return $res->withRedirect('/');
        }

        $link =  "<a href='https://".$_SERVER['HTTP_HOST']."/activation/".urlencode($d['username'])."/".urlencode($token)."'>Link</a>";

        $message = (new \Swift_Message('Email Confirmation'))
            ->setFrom('admin@matcha.fr')
            ->setTo($d['email'])
            ->setBody('Follow this ' . $link . ' to confirm your email.');

        if ($this->mailer->send($message) === 0) {
            $this->flash->addMessage('danger', 'An error occured during email confirmation.');

            return $res->withRedirect('/');
        }
        unset($_SESSION['username']);
        unset($_SESSION['active']);
        unset($_SESSION['register']);
        unset($_COOKIE['username']);
        setcookie('username', null, -1, '/');

        $this->flash->addMessage('success', 'Confirmation email sent !');
        unset($_SESSION['old']);

        return $res->withRedirect('/');
    }

    public function signin(Request $req, Response $res)
    {
        $d = $req->getParams();
        $v = new Validator($this->flash, $d);

        $v->setInput('sign_username')->notEmpty()->userExist();
        $v->setInput('sign_password')->noWhiteSpace()->notEmpty();

        if ($v->failed()) {
            return $res->withRedirect('/');
        }

        if (User::checkPwd($d['sign_username'], $d['sign_password']) === false) {
            $this->flash->addMessage('log_error', 'Wrong Login or Password.');

            return $res->withRedirect('/');
        }
        $data = User::where('username', '=', $d['sign_username']);
        if ($data[0]['active'] === 0) {
            $this->flash->addMessage('confirm', 'Please confirm your email before SignIn.');

            return $res->withRedirect('/');
        }
        if ($data[0]['register'] === 0) {
            $_SESSION['username'] = $d['sign_username'];
            $_SESSION['active'] = 1;
            return $res->withRedirect('/registration');
        }

        $_SESSION['register'] = 1;
        $_SESSION['username'] = $d['sign_username'];
        if ($d['remember'] == 'on') {
            setcookie('username', $_SESSION['username'], time() + (60*60*24) * 10, null, null, false, true);
        }

        return $res->withRedirect('/home');
    }


    public function activation (Request $req, Response $res)
    {
        $d = $req->getAttributes();

        if (User::checkActivation($d['username'], $d['token']) === false || User::activate($d['username']) === false)
        {
            $this->container->flash->addMessage('danger', 'An Error occured during Account Activation.');
            return $res->withRedirect('/');
        }

        $_SESSION['username'] = $d['username'];
        $_SESSION['active'] = 1;
        return $res->withRedirect('/registration');
    }

    public function registration (Request $req, Response $res)
    {
        $d = $req->getParams();
        $files = $req->getUploadedFiles();
        $i = 1;

        $v = new Validator($this->flash, $d);

        $v->setInput('gender')->notEmpty();
        $v->setInput('orientation')->notEmpty();
        $v->setInput('day')->notEmpty();
        $v->setInput('month')->notEmpty();
        $v->setInput('year')->notEmpty();
        $v->setInput('bio')->notEmpty();
        $v->setInput('tag')->notEmpty();

        if ($v->failed() || !User::legalAge($req->getParams(), $this)) {
            return $res->withRedirect('/registration');
        }

        foreach ($files as $file) {
            if (empty($file->file) && $i > 1) {
                break;
            }
            if (User::checkFile($file) === false) {
                $this->flash->addMessage('file_'.$i.'_error', 'Input must be a valid Image');
                return $res->withRedirect('/registration');
            }
            $i++;
        }

        if (User::register ($_SESSION['username'], $d, $files) === false)
        {
            return $res->withRedirect('/registration');
        }
        $_SESSION['register'] = 1;

        return $res->withRedirect('/home');
    }

    public function passwordReset (Request $req, Response $res)
    {
        $arg = $req->getParams();
        $token = md5(microtime(TRUE) * 100000);
        $tokenDate = new \DateTime('now');

        $v = new Validator($this->flash, $req->getParams());

        $v->setInput('resetEmail')->email();

        if ($v->failed()) {
            return $res->withRedirect($_SERVER['HTTP_REFERER']);
        }

        $d = User::whereOne('email', '=', $arg['resetEmail']);

        if (!empty($d['username'])) {
            $sql = $this->pdo
                ->update([
                    'token' => $token,
                    'token_date' => $tokenDate->format('Y-m-d H:i:s')
                ])
                ->table('user')
                ->where('username', '=', $d['username']);
            $sql->execute();

            $link = "<a href='https://" . $_SERVER['HTTP_HOST'] . "/password-reset/" . urlencode($d['username']) . "/" . urlencode($token) . "'>Link</a>";

            $message = (new \Swift_Message('Password reset'))
                ->setFrom('admin@matcha.fr')
                ->setTo($d['email'])
                ->setBody('Follow this ' . $link . ' to reset your password.');

            if ($this->mailer->send($message) === 0) {
                $this->flash->addMessage('danger', 'An error occured during password reset email sending.');

                return $res->withRedirect('/');
            }
            $this->flash->addMessage('success', 'Password reset email sent.');
        } else {
            $this->flash->addMessage('danger', 'No user found !');
        }

        return $res->withRedirect($_SERVER['HTTP_REFERER']);
    }

    public function resetAction (Request $req, Response $res, $arg)
    {
        $v = new Validator($this->flash, $req->getParams());

        $v->setInput('password')->noWhiteSpace()->notEmpty()->password();
        $v->setInput('confirmation')->noWhitespace()->notEmpty()->equals($req->getParam('password'));

        if ($v->failed()) {
            return $res->withRedirect($_SERVER['HTTP_REFERER']);
        }

        $post = $req->getParams();
        $date = new \DateTime('now');
        $user = User::whereOne('token', '=', $arg['token']);
        $token_date = new \DateTime($user['token_date']);

        if (empty($user) || (array)$date->diff($token_date) > (array) new \DateInterval('PT30M')) {
            $this->flash->addMessage('danger', (empty($user)) ? 'No user found !' : 'Email expired !');

            return $res->withRedirect('/');
        }

        $sql = $this->pdo
            ->update(['password' => password_hash($post['password'], PASSWORD_DEFAULT)])
            ->table('user')
            ->where('token', '=', $arg['token']);
        $sql->execute();

        $this->flash->addMessage('success', 'Password changed !');

        return $res->withRedirect('/');
    }

    public function resendConfirm (Request $req, Response $res)
    {
        $arg = $req->getParams();
        $token = md5(microtime(TRUE) * 100000);
        $date = new \DateTime('now');
        $tokenDate = $date->add(new \DateInterval('PT15M'));

        $v = new Validator($this->flash, $req->getParams());

        $v->setInput('confirmEmail')->email();

        if ($v->failed()) {
            return $res->withRedirect($_SERVER['HTTP_REFERER']);
        }

        $d = User::whereOne('email', '=', $arg['confirmEmail']);

        if (!empty($d['username'])) {
            $sql = $this->pdo
                ->update([
                    'token' => $token,
                    'token_date' => $tokenDate->format('Y-m-d H:i:s')
                ])
                ->table('user')
                ->where('username', '=', $d['username']);
            $sql->execute();

            $link =  "<a href='https://".$_SERVER['HTTP_HOST']."/activation/".urlencode($d['username'])."/".urlencode($token)."'>Link</a>";

            $message = (new \Swift_Message('Email Confirmation'))
                ->setFrom('admin@matcha.fr')
                ->setTo($d['email'])
                ->setBody('Follow this ' . $link . ' to confirm your email.');

            if ($this->mailer->send($message) === 0) {
                $this->flash->addMessage('danger', 'An error occured during email confirmation.');

                return $res->withRedirect('/');
            }
        } else {
            $this->flash->addMessage('danger', 'No user found !');

            return $res->withRedirect('/');
        }

        $this->flash->addMessage('success', 'Confirmation email sent !');
        unset($_SESSION['old']);
        return $res->withRedirect('/');
    }
}
