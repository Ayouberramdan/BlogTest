<?php


namespace App\model;


use App\helpers\Text;

class Post
{
    private $id ;
    private $name ;
    private $slug ;
    private $created_at ;
    private $content ;

    public function getName() :?string
    {
        return $this->name ;
    }

    public function getContent() :?string
    {
        return nl2br(htmlentities($this->content));
    }
    public function getExpert() :?string
    {
        if($this->content === null){
            return null ;
        }
        return nl2br(htmlentities(Text::expert($this->content , 60 )));
    }

    public function getCreatedAt() :?\DateTime
    {
        return new \DateTime($this->created_at);
    }

    public function getSlug() :?string
    {
        return $this->slug;
    }

    public function getId() :?int
    {
        return  $this->id ;
    }


}