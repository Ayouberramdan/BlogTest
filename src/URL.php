<?php


namespace App;


class URL
{
    public static function getInt(string $name, ?int $default = null): ?int
    {
        if (!isset($_GET[$name])) return $default;
        if ($_GET[$name] === 0) return 0 ;
        if (!filter_var($_GET[$name], FILTER_VALIDATE_INT)) {
            throw new \Exception("le parametre $name n'est pas valid");
        }
        return (int)$_GET[$name];
    }

    public static function getPositivrInt(string $name, ?int $default = null): ?int
    {
        $param = self::getInt($name, 1);
        if ($param <= 0) {
            throw new \Exception("Numero de $name n'est pas positive");
        }
        return $param;
    }
}
