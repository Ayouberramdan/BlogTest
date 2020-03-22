<?php


namespace App;


class Router
{
    /*
     * @var string
     */
    private $viewPath ;
    /*
     * @var altorouter
     */
    private $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url , string $view , ?string $name = null):self
    {
        $this->router->map('GET' , $url , $view , $name);
        return $this ;
    }

    public function run():self
    {
        $match = $this->router->match();
        $view = $match['traget'];
        require $this->viewPath . $view . 'php';
        return  $this ;

    }


}