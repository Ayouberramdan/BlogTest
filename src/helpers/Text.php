<?php


namespace App\helpers;


class Text
{
    public static function expert(string $text , int $limit=60 ){
        if(mb_strlen($text) <= $limit){
            return $text ;
        }else{
            $lastSpace = mb_strpos($text , ' ' , $limit);
            return mb_substr($text , 0 , $lastSpace) . '...';
        }
    }

}