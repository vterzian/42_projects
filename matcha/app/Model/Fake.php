<?php

namespace App\Model;

class Fake
{
    public static function addFake ($faker, $faked)
    {
        $pdo = Pdo::getInstance();
        $fake_date = new \DateTime('now');

        $sql = $pdo->getDb()
            ->insert(['faker_id', 'faked_id', 'fake_date'])
            ->into('fake')
            ->values([$faker, $faked, $fake_date->format('Y-m-d H:i:s')]);

        return $sql->execute();
    }

    public static function unFake ($faker, $faked)
    {
        $pdo = Pdo::getInstance();

        $sql = $pdo->getDb()
            ->delete(   )
            ->from('fake')
            ->where('faker_id', '=', $faker)
            ->where('faked_id', '=', $faked);

        return $sql->execute();
    }

    public static function ifFake ($faker, $faked)
    {
        $pdo = Pdo::getInstance();

        $fakerId = User::whereOne('username', '=', $faker);
        $fakedId = User::whereOne('username', '=', $faked);

        $sql = $pdo->getDb()
            ->select()
            ->from('fake')
            ->where('faker_id', '=', $fakerId['id'])
            ->where('faked_id', '=', $fakedId['id']);
        $exec = $sql->execute();

        return $exec->rowCount();
    }
}