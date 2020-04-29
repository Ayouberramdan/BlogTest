<?php
use App\model\Post;
use App\model\Category;
$id = $params['id'];
$slug = $params['slug'];
$pdo = \App\Connection::getPDO();
$query = $pdo->prepare("SELECT * FROM category where id = :id");
$query->execute([ 'id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS , \App\model\Category::class);
/** @var $category \App\model\Category | false  */
$category = $query->fetch();
if($category === false){
throw new Exception("Aucune category ne correspend a ce $id");
}

if($category->getSlug() !== $slug){
$url = $router->url('category' , ['id' => $id , 'slug'=>$category->getSlug()]);
http_response_code(301);
header('location:' . $url);
}

$paginatedQuery = new \App\PaginatedQuery("SELECT post.* FROM post inner join post_category pc on post.id = pc.post_id where pc.category_id = {$category->getId()} order by created_at DESC ",
"SELECT count(post_id) from post_category where category_id = {$category->getId()}");

/** @var $posts \App\model\Post[] */
/** @var  $router \App\Router */
$posts = $paginatedQuery->getItems(Post::class);
$link = $router->url("category" , ["id" => $category->getId() , "slug" => $category->getSlug()]);
?>

<h1><?= htmlentities($category->getName())?></h1>

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
    <?= $paginatedQuery->getPerviousLink($router->url("category" , ["id" => $category->getId() , "slug" => $category->getSlug()]))?>
    <?= $paginatedQuery->getnextLink($router->url("category" , ["id" => $category->getId() , "slug" => $category->getSlug()]))?>
</div>