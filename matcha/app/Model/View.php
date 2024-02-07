<?php

namespace App\Model;

class View
{
    public static function addView ($viewerUsername, $viewedUsername)
    {
        $date = new \DateTime();
        $pdo = Pdo::getInstance();
        $viewer = User::whereOne('username', '=', $viewerUsername);
        $viewed = User::whereOne('username', '=', $viewedUsername);
        if (self::alreadyLiked($viewer['id'], $viewed['id']) === false) {
            $sql = $pdo->getDb()
                ->insert(['viewer_id', 'viewed_id', 'view_date'])
                ->into('views')
                ->values([$viewer['id'], $viewed['id'], $date->format('Y-m-d H:i:s')]);
            $sql->execute();
            User::updatePopularity($viewedUsername);
        }

        return true;
    }

    public static function alreadyLiked ($viewerId, $viewedId)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->select()
            ->from('views')
            ->where('viewer_id', '=', $viewerId)
            ->where('viewed_id', '=', $viewedId);
        $exec = $sql->execute();

        return  ($exec->rowCount() > 0) ? true : false;
    }

    public static function countView ($userId)
    {
        $pdo = Pdo::getInstance();

        $sql = $pdo->getDb()->select()->from('views')->where('viewed_id', '=', $userId);
        $exec = $sql->execute();

        return $exec->rowCount();
    }

    public static function getLastView ($userId)
    {
        $pdo = Pdo::getInstance();

        $sql = $pdo->getDb()
            ->select()
            ->from('views')
            ->where('viewed_id', '=', $userId)
            ->orderBy('view_date', 'DESC');
        $exec = $sql->execute();

        $views = $exec->fetchAll();

        $ret = [];
        foreach ($views as $v) {
            $user = User::whereOne('id', '=', $v['viewer_id']);
            array_push($ret, $user);
        }

        return $ret;
    }
}