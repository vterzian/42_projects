<?php

namespace App\Model;

use Slim\PDO\Database;

class Pdo
{
    private static $_instance;
    private $db;
    private $db_host = 'mysql';
    private $db_name = 'matcha';
    private $usr = 'root';
    private $pwd = '';

    public function __construct()
    {
        $dsn = 'mysql:host='.$this->db_host.';dbname='.$this->db_name.';charset=utf8';
        $this->db = new Database($dsn, $this->usr, $this->pwd);
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Pdo();
        }
        return self::$_instance;
    }

    public function getDb()
    {
        return $this->db;
    }
}
