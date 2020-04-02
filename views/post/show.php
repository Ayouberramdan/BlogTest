<?php
$id = $params['id'];
$slug = $params['slug'];
$pdo = \App\Connection::getPDO();
$query = $pdo->prepare("SELECT * FROM post where id = :id");
$query->execute([ 'id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS , \App\model\Post::class);
/** @var $post \App\model\Post | false  */
$post = $query->fetch();
if($post === false){
    throw new Exception("Aucun article ne correspend a ce $id");
}

if($post->getSlug() !== $slug){
    $url = $router->url('post' , ['id' => $id , 'slug'=>$post->getSlug()]);
    http_response_code(301);
    header('location:' . $url);
}

$queryCategory = $pdo->prepare("SELECT category.id ,category.name, category.slug  FROM category inner join post_category on post_category.category_id = category.id where post_category.post_id = :id");
$queryCategory->execute(['id' => $id]);
/** @var  $categorys \App\model\Category[] */
$categorys = $queryCategory->fetchAll(PDO::FETCH_CLASS , \App\model\Category::class);
?>

<div class="jumbotron">
    <h1 class="display-5"><?= htmlentities($post->getName())?></h1>
    <hr class="my-2">
    <?php foreach ($categorys as $category) :?>
    <a href="<?= $router->url('category' , ['id' => $category->getId() , 'slug' => $category->getSlug()]) ?>"><?= $category->getName()?></a></br>
    <?php endforeach;?>
    <hr class="my-2">
    <p><?= $post->getContent() ?></p>
    <p class="lead">
        <p><?= $post->getCreatedAt()->format('d F Y')?></p>
    </p>
</div>
