<?php


namespace App;
use \PDO ;


class PaginatedQuery
{
    private $query ;
    private $queryCount ;
    private $pdo ;
    private $perpage ;
    private $count;
    private $items ;


    public function __construct(string $query , string $queryCount ,?\PDO $pdo = null,int $perpage = 12 )
    {
        $this->query=$query;
        $this->queryCount = $queryCount ;
        $this->pdo = $pdo ?:Connection::getPDO();
        $this->perpage=$perpage;
    }

    public function getItems(string $classMaping ) : array
    {
        if($this->items === null){
            $currentPage = $this->getCurrentPage();
            $pages = $this->getPages();
            if ($currentPage > $pages) {
                throw new Exception("Cette page n'existe pas");
            }
            //calcul offset formule
            $offset = $this->perpage * ($currentPage - 1);
            $this->items = $this->pdo
                ->query($this->query . " LIMIT $this->perpage OFFSET $offset")
                ->fetchAll(\PDO::FETCH_CLASS, $classMaping);
        }
        return $this->items;
    }

    public function getPerviousLink(string $link) : ?string
    {
        $currentPage = $this->getCurrentPage();
        if($currentPage <= 1 ) return null ;
        if($currentPage > 2) $link .= "?page=" . ($currentPage-1) ;
            return <<<HTML
 <a href="{$link}" class="btn btn-primary" > &laquo; page precedente</a>
HTML;
    }


    public function getnextLink(string $link) : ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if($currentPage >= $pages  ) return null ;
        $link .= "?page=" . ($currentPage+1);
        return <<<HTML
        <a href="{$link}" class="btn btn-primary ml-auto"> page suivate &raquo;</a>
HTML;
    }



    public function getCurrentPage():int
    {
        return URL::getPositivrInt('page', 1);

    }

    private function getPages() : int
    {
        if($this->count === null){
            $this->count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }
        //arrendire de nombre
        return ceil($this->count / $this->perpage);
    }

}