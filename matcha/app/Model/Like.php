<?php

namespace App\Model;

class Like
{
    public static function addLike ($likerUsername, $likedUsername)
    {
        $date = new \DateTime();
        $pdo = Pdo::getInstance();

        $user1 = User::whereOne('username', '=', $likerUsername);
        $likerId = $user1['id'];

        $user = User::whereOne('username', '=', $likedUsername);
        $likedId = $user['id'];
        if (self::alreadyLiked($likerId, $likedId) === false) {
            $sql = $pdo->getDb()
                ->insert(['like_id', 'liked_id', 'like_date'])
                ->into('likes')
                ->values([$likerId, $likedId, $date->format('Y-m-d H:i:s')]);
            $sql->execute();
            Notif::addNotif($user['id'], $user1['file_1'], ucwords($user1['username']) . " like you !");
            if (self::alreadyLiked($likedId, $likerId)) {
                Notif::addNotif($user['id'], $user1['file_1'],ucwords($user1['username']) . " is connected with you !");
                Notif::addNotif($user1['id'], $user['file_1'],ucwords($user['username']) . " is connected with you !");
            }
        }

        return true;
    }

    public static function unlike ($likerUsername, $likedUsername)
    {
        $pdo = Pdo::getInstance();

        $user1 = User::whereOne('username', '=', $likerUsername);
        $likerId = $user1['id'];

        $user = User::whereOne('username', '=', $likedUsername);
        $likedId = $user['id'];

        $sql = $pdo->getDb()
            ->delete()
            ->from('likes')
            ->where('like_id', '=', $likerId)
            ->where('liked_id', '=', $likedId);

        return $exec = $sql->execute();
    }

    public static function alreadyLiked ($likerId, $likedId)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->select()
            ->from('likes')
            ->where('like_id', '=', $likerId)
            ->where('liked_id', '=', $likedId);
        $exec = $sql->execute();

        return  ($exec->rowCount() > 0) ? true : false;
    }

    public static function countLike ($userId)
    {
        $pdo = Pdo::getInstance();

        $sql = $pdo->getDb()->select()->from('likes')->where('liked_id', '=', $userId);
        $exec = $sql->execute();

        return $exec->rowCount();
    }

    public static function getLastLike ($userId)
    {
        $pdo = Pdo::getInstance();

        $sql = $pdo->getDb()
            ->select()
            ->from('likes')
            ->where('liked_id', '=', $userId)
            ->orderBy('like_date', 'DESC');;
        $exec = $sql->execute();

        $likes = $exec->fetchAll();
        $ret = [];
        foreach ($likes as $l) {
            $user = User::whereOne('id', '=', $l['like_id']);
            array_push($ret, $user);
        }

        return $ret;
    }

    public static function ifLiked ($likerName, $likedName)
    {
        $likeId = User::whereOne('username', '=', $likerName);
        $likedId = User::whereOne('username', '=', $likedName);

        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->select()
            ->from('likes')
            ->where('like_id', '=', $likeId['id'])
            ->where('liked_id', '=', $likedId['id']);
        $exec = $sql->execute();

        return $exec->rowCount();
    }
}
