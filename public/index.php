<?php
require '../vendor/autoload.php';

//elimination ?page=1
if(isset($_GET['page']) && $_GET['page']==='1'){
    $uri = explode('?' , $_SERVER[ "REQUEST_URI"])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    if(!empty($query)){
        $uri = $uri . '?' . $query ;
    }
    http_response_code(301);
    header('location:' . $uri);
    exit();


}

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new \App\Router(dirname(__DIR__) . '/views');
$router->get('/','post/index' , 'home' )
        ->get('/blog/[*:slug]-[i:id]' , 'post/show' , 'post')
        ->get( "/blog/category" , 'category/show' , 'category')
        ->run();


?>
