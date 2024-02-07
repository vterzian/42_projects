<?php

namespace App\Model;

class Chat
{
    public static function addMessage ($to, $content) {
        if (empty($content)) {
            return 0;
        }
        $pdo = Pdo::getInstance();
        $date = new \DateTime('now');
        $user = User::whereOne('username', '=', $_SESSION['username']);
        $sql = "INSERT INTO chat (`from`, `to`, `content`, `date`, `read`) VALUES ('" . $user['id'] . "', '" . $to . "', '" . $content . "', '" . $date->format('Y-m-d H:i:s') . "', '" . 0 . "')";
        $tmt = $pdo->getDb()->prepare($sql);

        return $tmt->execute();
    }

    public static function getMessages ($user) {
        $pdo = Pdo::getInstance();
        $cuser = User::whereOne('username', '=', $_SESSION['username']);
        $sql = "SELECT * FROM chat WHERE (`from` = " . $user . " AND `to` = " . $cuser['id'] . ") OR (`from` = " . $cuser['id'] . " AND `to` = " . $user . ") ORDER BY `date` ASC";
        $stmt = $pdo->getDb()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function countUnreadMessages ($user) {
        $messages = self::getMessages($user['id']);

        foreach ($messages as $key => $m) {
            if ($m['read'] === 1 || $m['from'] != $user['id']) {
                unset($messages[$key]);
            }
        }
        $mess = array_values($messages);

        return count($mess);
    }

    public static function readAll ($user) {
        $pdo = Pdo::getInstance();
        $user = User::whereOne('username', '=', $user);
        $cuser = User::whereOne('username', '=', $_SESSION['username']);

        $sql = "UPDATE chat SET `read` = 1 WHERE (`from` = '" . $user['id'] . "' AND `to` = '" . $cuser['id'] . "')";
        $stmt = $pdo->getDb()->prepare($sql);

        return $stmt->execute();
    }

    public static function getAllConnection () {
        $pdo = Pdo::getInstance();
        $user = User::whereOne('username', '=', $_SESSION['username']);
        $sql = $pdo->getDb()->select()->from('likes')->where('liked_id', '=', $user['id'])->orWhere('like_id', '=', $user['id']);
        $exec = $sql->execute();
        $data = $exec->fetchAll();

        $connectedWith = [];
        $connectedTo = [];
        foreach ($data as $d) {
            if ($user['id'] === $d['like_id']) {
                array_push($connectedTo, $d['liked_id']);
            } elseif ($user['id'] === $d['liked_id']) {
                array_push($connectedWith, $d['like_id']);
            }
        }
        $connected = [];
        foreach ($connectedWith as $c) {
            if (in_array($c, $connectedTo)) {
                array_push($connected, $c);
            }
        }
        if (empty($connected)) {
            return $data = '';
        }
        $sql = $pdo->getDb()->select()->from('user')->whereIn('id', $connected);
        $exec = $sql->execute();
        $data = $exec->fetchAll();
        return $data;
        $i = 0;
        if (!empty($data)) {
            while ($data[$i]) {
                $data[$i]['online'] = Connected::connected($data[$i]['username']);
                $i++;
            }
        }

        return $data;
    }
}