<?php
global $SES;

// require_once("./src/controllers/PostController.php");
// require_once("./src/controllers/posts/PostUtilities.php");

// Kontroler i serwisy powinny być przekazane z routera
/** @var PostController $postController */
/** @var PostService $postService */

$postController = new PostController();
$postService = new PostService($postController);
// $postUtils = new PostUtilities();

$posts = $postController->getPosts(4); // Get 4 latest posts
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
            $metadata = $postService->getPostMetadata($post['id']);
            echo '
            <div class="col">
                <div class="blog-card h-100">
                    <div class="card-body d-flex flex-column p-4">
                        <h2 class="h4 card-title mb-3" style="min-height: 48px;">
                            <a class="text-decoration-none text-dark" href="/blogez2/wpis/' . $post['id'] . '">' . $post['title'] . '</a>
                        </h2>

                        <div class="d-flex flex-column" style="flex: 1;">
                            <p class="card-text mb-4" style="height: 96px; overflow: hidden;">
                                ' . $metadata['excerpt'] . '
                            </p>
                            <div class="mt-auto">
                                <a class="btn btn-gradient w-100 mb-3" href="/blogez2/wpis/' . $post['id'] . '">
                                    Czytaj dalej
                                </a>
                                <div class="card-footer bg-transparent border-top pt-3">
                                    <div class="author">
                                        <p class="mb-1">Autor: ' . $metadata['author'] . '</p>
                                        <p class="mb-0">Data publikacji: ' . $metadata['date'] . '</p>
                                    </div>
                                </div>
                            </div>
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