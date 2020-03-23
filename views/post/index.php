<?php

use App\helpers\Text;
use App\model\Post;

$pdo = new PDO('mysql:dbname=tutoblog;host=127.0.0.1:3306','root' , '' , [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$query = $pdo->query("SELECT * FROM post order by created_at DESC LIMIT 12");
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
                    <a href="#" class="btn btn-secondary">Voir plus</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
