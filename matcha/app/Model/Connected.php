<?php

namespace App\Model;

use App\Model\Pdo;
use App\Model\User;

class Connected
{
    public static function stillAlive () {
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            $pdo = Pdo::getInstance();
            $user = User::whereOne('username', '=', $_SESSION['username']);
            $date = new \DateTime();

            $sql = $pdo->getDb()
                ->select()
                ->from('connected')
                ->where('user_id', '=', $user['id']);
            $exec = $sql->execute();

            if ($exec->rowCount() > 0) {
                $sql = $pdo->getDb()
                    ->delete()
                    ->from('connected')
                    ->where('user_id', '=', $user['id']);
                $sql->execute();
            }

            $sql = $pdo->getDb()
                ->insert(['user_id', 'connect_date'])
                ->into('connected')
                ->values([$user['id'], $date->format('Y-m-d H:i:s')]);
            $sql->execute();
        }
    }

    public static function connected ($username) {
        $pdo = Pdo::getInstance();
        $user = User::whereOne('username', '=', $username);
        $today = new \DateTime('now');
        $interval = new \DateInterval('PT11S');

        $sql = $pdo->getDb()
            ->select()
            ->from('connected')
            ->where('user_id', '=', $user['id']);
        $exec = $sql->execute();

        if ($exec->rowCount() > 0) {
            $data = $exec->fetch();
            $date = new \DateTime($data['connect_date']);

            if ((array)$date->diff($today) < (array)$interval) {
                return 1;
            }
        }

        return 0;
    }

    public static function lastConnection ($username) {
        $pdo = Pdo::getInstance();
        $user = User::whereOne('username', '=', $username);

        $sql = $pdo->getDb()
            ->select()
            ->from('connected')
            ->where('user_id', '=', $user['id']);
        $exec = $sql->execute();

        return $exec->fetch();
    }
}