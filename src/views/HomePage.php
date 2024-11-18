<?php
global $SES;

require_once("./src/controllers/posts/PostController.php");
require_once("./src/controllers/posts/PostUtilities.php");

$Post = new PostsController();
$posts = $Post->getPosts(4);
$PostUtil = new PostUtilities();

?>
<section id="hero" class="container mt-5">
    <h1 class="text-center main-title mb-5">Blogez - zacznij swoją przygodę z wpisami</h1>
    <?php if (!$SES->IsLogged()) { ?>
        <div class="mt-5">
            <p class="text-center text-muted">Masz już konto? Jeśli nie możesz je założyć tu:</p>
        </div>
        <div class="row g-4">
            <div class="col-sm-6">
                <div class="auth-card">
                    <div class="card-body p-4">
                        <h5 class="card-title">Nie jestem tu pierwszy raz</h5>
                        <p class="card-text text-muted">Klikając tu szybko przejdziesz do logowania :)</p>
                        <a href="/blogez2/konto/login/" class="btn btn-gradient">Logowanie</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="auth-card">
                    <div class="card-body p-4">
                        <h5 class="card-title">To moja pierwsza styczność z blogez!</h5>
                        <p class="card-text text-muted">W takim razie zapraszamy do rejestracji. Nie zbieramy waszych danych.</p>
                        <a href="/blogez2/konto/register" class="btn btn-gradient">Rejestracja</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>

<section class="container mt-5">
    <h2 class="text-center mb-4">Najnowsze wpisy naszych użytkowników</h2>
    <div class="row row-cols-1 row-cols-md-2 g-4 mt-4">
        <?php
        foreach ($posts as $post) {
            echo '
            <div class="col">
                <div class="blog-card h-100">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="flex-grow-1">
                            <p class="h3 card-title mb-3"><a class="text-decoration-none text-dark" href="/blogez2/wpis/' . $post['id'] . '">' . $post['title'] . '</a></p>
                            <p class="card-text">' . $PostUtil->PostUExcerpt($post['id']) . '</p>
                        </div>
                        <div class="card-footer">
                            <div class="author mb-2">
                                <p class="mb-0">Autor: ' . $Post->getPostAuthor($post['id']) . '</p>
                                <p>Data publikacji: ' . date('d M Y', strtotime($post['created_at'])) . '</p>
                            </div>
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
</section>

<style>
    /* .main-title {
    color: #2d3436;
    font-weight: 700;
    margin-bottom: 2rem;
}

.auth-card {
    background: linear-gradient(145deg, #ffffff, #f5f7fa);
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
    text-align: center;
}

.auth-card:hover {
    transform: translateY(-5px);
}

.btn-gradient {
    background: linear-gradient(45deg, #0984e3, #00b894);
    border: none;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background: linear-gradient(45deg, #00b894, #0984e3);
    transform: translateY(-2px);
    color: white;
}

.blog-card {
    background: linear-gradient(145deg, #ffffff, #f5f7fa);
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}

.card-footer {
    background: transparent;
    border-top: 1px solid #eee;
    padding-top: 1rem;
}

.author {
    color: #6c757d;
    font-size: 0.9rem;
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
    color: #00b894;
} */
</style>