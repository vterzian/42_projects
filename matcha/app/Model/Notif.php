<?php

namespace App\Model;

class Notif
{
    public static function getNotif ($user) {
        $pdo = Pdo::getInstance();
        $user = User::whereOne('username', '=', $user);

        $sql = $pdo->getDb()->select()->from('notif')->where('user_id', '=', $user['id'])->orderBy('date', 'DESC');
        $exec = $sql->execute();

        return $exec->fetchAll();
    }

    public static function addNotif ($user, $img, $content) {
        $pdo = Pdo::getInstance();
        $date = new \DateTime('now');

        $sql = $pdo->getDb()
            ->insert([
                'user_id',
                'content',
                'img',
                'date'
            ])
            ->into('notif')
            ->values([
                $user,
                $content,
                $img,
                $date->format('Y-m-d H:i:s')
            ]);

        return $exec = $sql->execute();
    }

    public static function readNotif ($id) {
        $pdo = Pdo::getInstance();
        $sql = "UPDATE notif SET `read` = 1 WHERE `id` = " . $id;
        $exec = $pdo->getDb()->prepare($sql);

        return $exec->execute();
    }

    public static function intervalDate ($date) {
        $today = new \DateTime('now');
        $ret = new \DateTime($date);

        if ((array)($v = $ret->diff($today)) > (array)new \DateInterval('P1Y')) {
            return $v->y . " y.";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('P1M')) {
            return $v->m . " m.";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('P1D')) {
            return $v->d . " d.";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('PT1H')) {
            return $v->h . " h.";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('PT1M')) {
            return $v->i . " min.";
        } elseif ((array)($v = $ret->diff($today)) > (array)new \DateInterval('PT1S')) {
            return $v->s . " sec.";
        }


        return "Some time";
    }
}