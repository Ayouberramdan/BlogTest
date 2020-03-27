<?php

use App\helpers\Text;
use App\model\Post;

$pdo = new PDO('mysql:dbname=tutoblog;host=127.0.0.1:3306','root' , '' , [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
//pagination
$page = $_GET['page'] ?? 1;
if (!filter_var($page , FILTER_VALIDATE_INT)){
    throw new Exception("Numero de page invalide");
}
//elimination ?page=1
if($page==="1"){
    header('location :' . $router->url('home'));
    http_response_code(301); //http code redirection
    exit();
}

$currentPage = (int)$page ;
if ($currentPage <= 0 ){
    throw new Exception("Numero de page invalide");
}
$count = (int)$pdo->query("SELECT count(id) from post")->fetch(PDO::FETCH_NUM)[0];
$perpage = 12;
$pages = ceil($count/$perpage); //cette fonction vas arrendire le nombre
if($currentPage > $pages){
    throw new Exception("Cette page n'existe pas");
}
//calcul offset formule
$offset = $perpage * ($currentPage - 1);
$query = $pdo->query("SELECT * FROM post order by created_at DESC LIMIT $perpage OFFSET $offset ");
$posts = $query->fetchAll(PDO::FETCH_CLASS , Post::class);
?>
<h1>Mon Blog</h1>
<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header"><?= htmlentities($post->getName())?></div>
                <div class="card-body">
                    <p><?= $post->getCreatedAt()->format('d F Y') ?></p>
                    <p class="card-text"><?= $post->getExpert();?></p>
                    <a href="<?= $router->url('post' , ['id'=> $post->getId() , 'slug' => $post->getSlug()]) ?>" class="btn btn-secondary">Voir plus</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>
        <a href="<?= $router->url('home')?>?page=<?= $currentPage-1?>" class="btn btn-primary" > &laquo; page precedente</a>
    <?php endif;?>

    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('home')?>?page=<?= $currentPage+1?>" class="btn btn-primary ml-auto"> page suivate &raquo;</a>
    <?php endif;?>
</div>