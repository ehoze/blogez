<?php
require_once("./src/controllers/PostController.php");
$postController = new PostController();
$post = $postController->getPost($id);
?>

<div class="container py-5">
    <div class="article-container">
        <div class="article-header">
            <h1 class="article-title"><?= $post->getTitle() ?></h1>
            <div class="article-meta">
                <span class="post-date"><?= date('d M Y', strtotime($post->getCreatedAt())) ?></span>
                <span class="post-author">Autorstwa: <?= $post->getAuthorName($id) ?></span>
            </div>
        </div>
        <div class="article-content">
            <?= $post->getContent() ?>
        </div>
    </div>
</div>

<style>
.article-container {
    max-width: 1400px;
    margin: 0 auto;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    padding: 3rem;
}

.article-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #eee;
}

.article-title {
    color: #2d3436;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.article-meta {
    color: #6c757d;
    font-size: 1rem;
}

.article-content {
    color: #2d3436;
    line-height: 1.8;
    font-size: 1.1rem;
}

.article-content p {
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .article-container {
        padding: 1.5rem;
    }
    
    .article-title {
        font-size: 2rem;
    }
}
</style>