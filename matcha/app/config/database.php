<?php

require_once __DIR__.'/../../vendor/autoload.php';

use \App\Model\Pdo;

$sql = file_get_contents(__DIR__.'/schema.sql');
try {
    $db_name = 'matcha';
    $pdo = Pdo::getInstance()->getDb();
    $exec = $pdo->prepare("CREATE DATABASE ".$db_name.";USE '".$db_name."';");
    $exec->execute();

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
