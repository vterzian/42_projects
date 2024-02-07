<?php

namespace App\Controller;

use App\Model\Chat;
use App\Model\Connected;
use App\Model\Notif;
use App\Model\Pdo;
use App\Model\User;
use Slim\Http\Response;
use Slim\Http\Request;


class GeneralController extends Controller
{
    public function connectedAction (Request $req, Response $res) {
        return json_encode(Connected::stillAlive());
    }

    public function stillConnectAction (Request $req, Response $res) {
        $data = Chat::getAllConnection();
        foreach ($data as $k => $v) {
            $data[$k]['connected'] = Connected::connected($v['username']);
            $data[$k]['nbrMess'] = Chat::countUnreadMessages($v);
        }

        return $res->withJson($data);
    }

    public static function getNotifAction (Request $req, Response $res) {
        $data = Notif::getNotif($_SESSION['username']);

        foreach ($data as $k => $v) {
            $data[$k]['time'] = Notif::intervalDate($v['date']);
        }

        return json_encode($data);
    }

    public static function countNotifAction (Request $req, Response $res) {
        $pdo = Pdo::getInstance();
        $user = User::whereOne('username', '=', $_SESSION['username']);

        $sql = "SELECT * FROM notif WHERE `user_id` = " . $user['id'] . " AND `read` = 0";
        $prep = $pdo->getDb()->prepare($sql);
        $prep->execute();

        return json_encode($prep->rowCount());
    }

    public static function readNotifAction (Request $req, Response $res) {
        $param = $req->getParams();

        return Notif::readNotif($param['id']);
    }
}
