<?php

use App\helpers\Text;
use App\model\Post;
use App\URL;

$pdo = \App\Connection::getPDO();

$paginatedQuery = new \App\PaginatedQuery("SELECT * FROM post order by created_at DESC",
"SELECT count(id) from post");
//pagination

/** @var $posts Post[] */
/** @var  $router \App\Router */
$posts = $paginatedQuery->getItems(Post::class);

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
    <?= $paginatedQuery->getPerviousLink($router->url('home'));?>
    <?= $paginatedQuery->getnextLink($router->url('home'));?>
</div>