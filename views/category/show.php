<?php
use App\helpers\Text;
use App\model\Post;

$id = $params['id'];
$slug = $params['slug'];
$pdo = \App\Connection::getPDO();
$query = $pdo->prepare("SELECT * FROM category where id = :id");
$query->execute([ 'id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS , \App\model\Category::class);
/** @var $category \App\model\Category | false  */
$category = $query->fetch();
if($category === false){
    throw new Exception("Aucun article ne correspend a ce $id");
}

if($category->getSlug() !== $slug){
    $url = $router->url('category' , ['id' => $id , 'slug'=>$post->getSlug()]);
    http_response_code(301);
    header('location:' . $url);
}

$currentPage = \App\URL::getPositivrInt('page' , 1) ;
$count = (int)$pdo->query("SELECT count(category_id) from post_category where category_id = {$category->getId()} ")
                ->fetch(PDO::FETCH_NUM)[0];
$perpage = 12;
$pages = ceil($count/$perpage); //cette fonction vas arrendire le nombre
if($currentPage > $pages){
    throw new Exception("Cette page n'existe pas");
}
//calcul offset formule
$offset = $perpage * ($currentPage - 1);
$query = $pdo->query("SELECT post.* FROM post 
                            inner join post_category pc on post.id = pc.post_id 
                            where pc.category_id = {$category->getId()}
                            order by created_at DESC 
                            LIMIT $perpage OFFSET $offset ");

$posts = $query->fetchAll(PDO::FETCH_CLASS , Post::class);


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
    <?php if ($currentPage > 1): ?>
        <a href="<?= $router->url('category' , ['id'=>$category->getId() , 'slug' => $category->getSlug()])?>?page=<?= $currentPage-1?>" class="btn btn-primary" > &laquo; page precedente</a>
    <?php endif;?>

    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('category' , ['id'=>$category->getId() , 'slug' => $category->getSlug()])?>?page=<?= $currentPage+1?>" class="btn btn-primary ml-auto"> page suivate &raquo;</a>
    <?php endif;?>

