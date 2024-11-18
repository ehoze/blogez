<?php
global $SES;
(!$SES->IsLogged()) ? header('Location:/blogez2/konto/', true, 301) : '';
if ($SES->GetUserPostsLeft() == 0) {
    $_SESSION['info_message'] = 'Nie masz już więcej wpisów do dodania.';
    header('Location:/blogez2/konto/', true, 301);
}
?>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>


<div class="container">

    <h1>Dodaj nowy wpis</h1>

    <form action="/blogez2/class/posts/CreatePost.php" method="POST">
        <div class="mb-3 col-auto">
            <label class="visually-hidden" for="name">Nazwa wpisu (h1)</label>
            <div class="input-group">
                <div class="input-group-text">@</div>
                <input type="text" class="form-control" name="title" id="title" placeholder="Nazwa wpisu">
            </div>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Treść wpisu (wysywig)</label>
            <textarea style="height:200px" class="form-control" name="content" id="content"></textarea>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">SEO tytuł - znacznik title</label>
            <input type="text" class="form-control" name="seo_title" id="seo_title">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">SEO opis - znacznik meta</label>
            <input type="text" class="form-control" name="seo_desc" id="seo_desc">
        </div>

        <button type="submit" class="btn btn-primary">Dodaj wpis</button>
    </form>

    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>


    <!-- <form action="/blogez/class/posts/CreatePost.php" method="POST">
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