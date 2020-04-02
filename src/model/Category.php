<?php


namespace App\model;


class Category
{
    private $id ;
    private $slug;
    private $name ;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}