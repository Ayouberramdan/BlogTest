<?php


namespace App;
use \PDO ;


class PaginatedQuery
{
    private $query ;
    private $queryCount ;
    private $classMaping;
    private $pdo ;
    private $perpage ;


    public function __construct(string $query , string $queryCount ,string $classMaping,?\PDO $pdo = null,int $perpage = 12 )
    {
        $this->query=$query;
        $this->queryCount = $queryCount ;
        $this->classMaping = $classMaping ;
        $this->pdo = $pdo ?:Connection::getPDO();
        $this->perpage=$perpage;
    }

    public function getItems() : array
    {
        $currentPage = URL::getPositivrInt('page', 1);
        $count = (int)$this->pdo
            ->query($this->queryCount)
            ->fetch(PDO::FETCH_NUM)[0];
        //arrendire de nombre
        $pages = ceil($count / $this->perpage);
        if ($currentPage > $pages) {
            throw new Exception("Cette page n'existe pas");
        }
        //calcul offset formule
        $offset = $this->perpage * ($currentPage - 1);
        return $this->pdo
            ->query($this->query . " LIMIT $this->perpage OFFSET $offset")
            ->fetchAll(\PDO::FETCH_CLASS, $this->classMaping);
    }

}