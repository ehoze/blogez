<?php
global $SES;
(!$SES->IsLogged()) ? header('Location:/blogez2/konto/', true, 301) : '';
if ($SES->GetUserPostsLeft() == 0) {
    $_SESSION['info_message'] = 'Nie masz już więcej wpisów do dodania.';
    header('Location:/blogez2/konto/', true, 301);
}
require_once('./src/controllers/posts/AccountPosts.php');
$accountPosts = new AccountPosts();

// Obsługa tworzenia posta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $accountPosts->addPost([
        'user_id' => $SES->GetUserId(),
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'seo_title' => $_POST['seo_title'],
        'seo_desc' => $_POST['seo_desc'],
        'visibility' => $_POST['visibility']
    ]);

    header('Location: /blogez2/konto/post/edit/' . $id);
    exit();
}

?>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>


<div class="container py-5">
    <?php if (isset($_SESSION['edit_message'])) {
        echo '<div class="alert alert-' . $_SESSION['edit_message_color'] . ' fade show" role="alert">' . $_SESSION['edit_message'] . '</div>';
        unset($_SESSION['edit_message']);
    } ?>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title mb-4 fw-bold">Dodaj nowy wpis</h1>
                    <!-- <form action="/blogez2/src/controllers/posts/CreatePost.php" method="POST"> -->
                    <form action="/blogez2/konto/post/create/" method="POST">
                        <ul class="nav nav-tabs mb-4" id="postTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Podstawowe</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="zaawansowane-tab" data-bs-toggle="tab" data-bs-target="#zaawansowane" type="button" role="tab" aria-controls="zaawansowane" aria-selected="false">Zaawansowane</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="postTabsContent">
                            <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                <div class="mb-3 col-auto">
                                    <label class="form-label" for="title">Nazwa wpisu (h1)</label>
                                    <div class="input-group">
                                        <div class="input-group-text">@</div>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Nazwa wpisu">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Treść wpisu</label>
                                    <textarea style="height:200px" class="form-control" name="content" id="content"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Widoczność wpisu</label>
                                    <select class="form-select" name="visibility" id="visibility">
                                        <option value="1">Publiczny</option>
                                        <option value="0">Prywatny</option>
                                    </select>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="mb-3">
                                    <label for="seo_title" class="form-label">SEO tytuł - znacznik title</label>
                                    <input type="text" class="form-control" name="seo_title" id="seo_title">
                                </div>

                                <div class="mb-3">
                                    <label for="seo_desc" class="form-label">SEO opis - znacznik meta</label>
                                    <input type="text" class="form-control" name="seo_desc" id="seo_desc">
                                </div>
                            </div>

                            <div class="tab-pane fade" id="zaawansowane" role="tabpanel" aria-labelledby="zaawansowane-tab">
                                <div class="mb-3">
                                    <label for="test" class="form-label">test</label>
                                    <input type="text" class="form-control" name="test" id="test">
                                </div>

                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">Dodaj wpis</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                ClassicEditor
                    .create(document.querySelector('#content'))
                    .catch(error => {
                        console.error(error);
                    });
            </script>


            <!-- <form action="/blogez2/class/posts/CreatePost.php" method="POST">
        <label for="title">Tytuł:</label>
        <input type="text" name="title" id="title" required><br><br>

        <label for="content">Treść:</label><br>
        <textarea name="content" id="content" rows="5" cols="40" required></textarea><br><br>

        <label for="seo_title">SEO Tytuł:</label>
        <input type="text" name="seo_title" id="seo_title"><br><br>

        <label for="seo_desc">SEO Opis:</label><br>
        <textarea name="seo_desc" id="seo_desc" rows="3" cols="40"></textarea><br><br>

        <button type="submit">Dodaj wpis</button>
    </form> -->



        </div>