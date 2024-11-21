<?php
// Kontroler i serwisy powinny być przekazane z routera
/** @var PostController $postController */
/** @var PostService $postService */

$posts = $postController->getPosts();
$postService = new PostService($postController);
?>

<div class="container py-5">
    <h1 class="text-center mb-4">Wszystkie wpisy</h1>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($posts as $post): 
            $metadata = $postService->getPostMetadata($post['id']);
        ?>
            <div class="col">
                <div class="blog-card h-100">
                    <div class="card-body d-flex flex-column p-4">
                        <h2 class="h4 card-title mb-3" style="min-height: 48px;">
                            <a class="text-decoration-none text-dark" 
                               href="/blogez2/wpis/<?= $post['id'] ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h2>
                        <div class="d-flex flex-column" style="flex: 1;">
                            <p class="card-text mb-4" style="height: 96px; overflow: hidden;">
                                <?= $metadata['excerpt'] ?>
                            </p>
                            <div class="mt-auto">
                                <a class="btn btn-gradient w-100 mb-3" href="/blogez2/wpis/<?= $post['id'] ?>">
                                    Czytaj dalej
                                </a>
                                <div class="card-footer bg-transparent border-top pt-3">
                                    <div class="author">
                                        <p class="mb-1">Autor: <?= htmlspecialchars($metadata['author']) ?></p>
                                        <p class="mb-0">Data publikacji: <?= $metadata['date'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.blog-card {
    background: linear-gradient(145deg, #ffffff, #f5f7fa);
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.post-date {
    color: #6c757d;
    font-size: 0.9rem;
    display: block;
}

.card-title {
    color: #2d3436;
    font-weight: 600;
}

.card-text {
    color: #636e72;
    line-height: 1.6;
}

.read-more {
    color: #0984e3;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
}

.read-more:hover {
    color: #0056b3;
}
</style>