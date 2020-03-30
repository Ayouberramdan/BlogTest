<?php


namespace App;
use \PDO;


class Connection
{
    public static function getPDO() : PDO
    {
        return new PDO('mysql:dbname=tutoblog;host=127.0.0.1:3306','root' , '' , [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

}