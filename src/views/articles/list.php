<?php
require_once("./src/controllers/posts/PostController.php");
require_once("./src/controllers/posts/PostUtilities.php");

$Post = new PostsController();
$posts = $Post->getPosts(); // Przypisanie danych posta do zmiennej $post

$PostUtil = new PostUtilities();
// $excerpt = $PostUtil->PostUExcerpt($posts['id']); // Uzyskanie skrótu posta
?>
<div class="container py-5">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php
        foreach ($posts as $post) {
            echo '
            <div class="col">
                <div class="blog-card h-100">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="flex-grow-1">
                            <span class="post-date mb-2">' . date('d M Y', strtotime($post['created_at'])) . '</span>
                            <h3 class="card-title mb-3">' . $post['title'] . '</h3>
                            <p class="card-text">' . $PostUtil->PostUExcerpt($post['id']) . '</p>
                        </div>
                        <div class="mt-3">
                            <a href="/blogez2/wpis/' . $post['id'] . '" class="read-more">
                                Czytaj dalej 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
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