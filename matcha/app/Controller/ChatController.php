<?php

namespace App\Controller;

use App\Model\Chat;
use App\Model\User;
use Slim\Http\Response;
use Slim\Http\Request;


class ChatController extends Controller
{
    public function getMessagesAction (Request $req, Response $res) {
        $param = $req->getParams();
        $user = User::whereOne('username', '=', $param['user']);
        $cuser = User::whereOne('username', '=', $_SESSION['username']);
        $messages = Chat::getMessages ($user['id']);

        $ret = '';
        if (!empty($messages)) {
            foreach ($messages as $m) {
                if ($m['from'] === $cuser['id']) {
                    $ret .= '<div class="mess-wrap grey-mess col-xs-12">';
                    $ret .= '<p class="mess">' . $m['content'] . '</p>';
                    $ret .= '</div>';
                } elseif ($m['from'] === $user['id']) {
                    $ret .= '<div class="mess-wrap blue-mess col-xs-12">';
                    $ret .= '<p class="mess">' . $m['content'] . '</p>';
                    $ret .= '</div>';
                }
            }
        }

        return $ret;
    }

    public function addMessageAction (Request $req, Response $res) {
        $param = $req->getParams();
        $to = User::whereOne('username', '=', strtolower($param['to']));
        $cuser = User::whereOne('username', '=', $_SESSION['username']);
        Chat::addMessage($to['id'], strip_tags(addslashes($param['content'])));
        $messages = Chat::getMessages ($to['id']);

        $ret = '';
        foreach ($messages as $m) {
            if ($m['from'] === $cuser['id']) {
                $ret .= '<div class="mess-wrap grey-mess col-md-12">';
                $ret .= '<p class="mess">' . $m['content'] . '</p>';
                $ret .= '</div>';
            } elseif ($m['from'] === $to['id']) {
                $ret .= '<div class="mess-wrap blue-mess col-md-12">';
                $ret .= '<p class="mess">' . $m['content'] . '</p>';
                $ret .= '</div>';
            }
        }

        return json_encode($ret);
    }

    public function newMessagesAction (Request $req, Response $res) {
        $ret = [];
        $i = 0;
        $data = Chat::getAllConnection();
        foreach ($data as $user) {
            $ret[$i] = Chat::countUnreadMessages($user);
            $i++;
        }

        return json_encode($ret);
    }

    public function readAllAction (Request $req, Response $res) {
        $param = $req->getParams();

        return Chat::readAll($param['user']);
    }
}
