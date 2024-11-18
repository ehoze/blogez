<?php
global $SES;
(!$SES->IsLogged()) ? header('Location:/blogez2/konto/', true, 301) : '';
require_once('./src/controllers/posts/PostController.php');

// Przetwarzanie formularza - dodajemy na początku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './src/controllers/posts/AccountPosts.php';
    $accountPosts = new AccountPosts();

    $params = [
        'user_id' => $SES->GetUserId(),
        'title' => $_POST['title'],
        'content' => $_POST['editor_content'], // Nowe pole z zawartością edytora
        'seo_title' => $_POST['seo_title'],
        'seo_desc' => $_POST['seo_desc']
    ];

    $accountPosts->editPost($params, $id);
    header('Location: /blogez2/konto/post/edit/'.$id); // Przekierowanie po zapisie
    exit();
}



$post = new PostsController();
$post = $post->getPost($id);
?>

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script> -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />


<div class="container py-5">
    <?php if (isset($_SESSION['edit_message'])) {
        echo '<div class="alert alert-' . $_SESSION['edit_message_color'] . ' fade show" role="alert">' . $_SESSION['edit_message'] . '</div>';
        unset($_SESSION['edit_message']);
    } ?>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title mb-4 fw-bold text-primary">Edycja wpisu: <?= $post['title'] ?></h1>

                    <form action="/blogez2/konto/post/edit/<?= $post['id'] ?>" method="POST">
                        <!-- <form action="/blogez/class/posts/EditPost.php" method="POST"> -->
                        <div class="mb-4">
                            <label class="form-label fw-medium" for="title">Nazwa wpisu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-heading"></i></span>
                                <input type="text" class="form-control form-control-lg" name="title" id="title" placeholder="Wpisz tytuł..." value="<?= $post['title'] ?>">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Treść wpisu</label>
                            <div id="editor" class="form-control" style="min-height: 300px;">
                                <?= $post['content'] ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium" for="seo_title">SEO tytuł</label>
                            <input type="text" class="form-control" name="seo_title" id="seo_title" value="<?= $post['seo_title'] ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium" for="seo_desc">SEO opis</label>
                            <textarea class="form-control" name="seo_desc" id="seo_desc" rows="3"><?= $post['seo_desc'] ?></textarea>
                        </div>

                        <!-- Dodajemy ukryte pole na zawartość edytora -->
                        <input type="hidden" name="editor_content" id="editor_content">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/blogez2/konto/" class="btn btn-light btn-lg px-4">Anuluj</a>
                            <button type="submit" class="btn btn-primary btn-lg px-4" onclick="setEditorContent()">Zapisz zmiany</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dodaj Font Awesome dla ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    // Dodajemy funkcję do przekazania zawartości edytora do formularza
    function setEditorContent() {
        const editorContent = document.querySelector('#editor_content');
        editorContent.value = quill.root.innerHTML;
    }
</script>

</div>