<?php

namespace App\Model;

class Tag
{
    public static function create ($tag)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('tag')->where('name', '=', $tag);
        $req = $sql->execute();
        $res = $req->fetch();
        if (empty($res)) {
            $sql = $pdo->getDb()
                ->insert(['name'])
                ->into('tag')
                ->values([strtolower($tag)]);
            return ($sql->execute()) ? true : false;
        }
        return false;
    }

    public static function createRelation ($userId, $tags)
    {
        $pdo = Pdo::getInstance();

        foreach ($tags as $tag) {
            $sql = $pdo->getDb()->select()->from('user_tag')->where('user_id', '=', $userId)->where('tag_id', '=', $tag);
            $req = $sql->execute();
            $res = $req->fetch();
            if (empty($res)) {
                $sql = $pdo->getDb()->insert(['user_id', 'tag_id'])->into('user_tag')->values([$userId, $tag]);
                if ($sql->execute() === false) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function saveTags ($tags)
    {
        $ret = [];
        $i = 0;
        $user = User::where('username', '=', $_SESSION['username']);
        $t = array_filter(explode(',', $tags));
        foreach ($t as $tag) {
            $row = self::whereOne ('name', '=', $tag);
            if ($row['name'] !== tag) {
                self::create($tag);
                $val = self::whereOne ('name', '=', $tag);
                $ret[$i] = $val['id'];
            } else {
                $ret[$i] = $row['id'];
            }
            $i++;
        }
        self::createRelation($user[0]['id'], $ret);
        return true;
    }

    public static function updateTag ($username, $tags)
    {
        $tag = array_filter(explode(';', $tags));

        $user = User::whereOne('username', '=', $username);
        $userTags = self::uWhere('user_id', '=', $user['id']);
        foreach ($userTags as $ta)
        {
            $tagN = self::whereOne('id', '=', $ta['tag_id']);
            if (!in_array($tagN['name'], $tag)) {
                self::delOneUserTag($user['id'], $ta['tag_id']);
            }
        }
        self::saveTags($tags);

        return true;
    }

    public static function delOneUserTag ($userId, $tagId)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->delete()->from('user_tag')->where('user_id', '=', $userId)->where('tag_id', '=', $tagId);

        return $sql->execute();
    }

    public static function where ($col, $symb, $value)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('tag')->where($col, $symb, $value);
        $data = $sql->execute();

        return $data->fetchAll();
    }

    public static function getAll ()
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('tag');
        $data = $sql->execute();

        return $data->fetchAll();
    }

    public static function whereOne ($col, $symb, $value)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('tag')->where($col, $symb, $value);
        $data = $sql->execute();

        return $data->fetch();
    }

    public static function uWhere ($col, $symb, $value)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user_tag')->where($col, $symb, $value);
        $data = $sql->execute();
        return $data->fetchAll();
    }

    public static function uWhereOne ($col, $symb, $value)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user_tag')->where($col, $symb, $value);
        $data = $sql->execute();

        return $data->fetch();
    }

    public static function uWhereIn ($col, $array)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user_tag')->whereIn($col, $array);
        $exec = $sql->execute();

        return $exec->fetchAll();
    }

    public static function countTag ($userId)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user_tag')->where('user_id', '=', $userId);
        $exec = $sql->execute();

        return $exec->rowCount();
    }
}
