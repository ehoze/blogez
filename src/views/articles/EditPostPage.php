<?php
global $SES;
(!$SES->IsLogged()) ? header('Location:/blogez2/konto/', true, 301) : '';

require_once('./src/services/AuthorizationService.php');
$authService = new AuthorizationService($SES);
$authService->requirePostEditPermission($id);

require_once('./src/controllers/PostController.php');
require_once('./src/controllers/posts/AccountPosts.php');
$accountPosts = new AccountPosts();

// Obsługa usuwania posta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $accountPosts->deletePost($id, $SES->GetUserId());
}

// Obsługa edycji posta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $accountPosts->editPost([
        'user_id' => $SES->GetUserId(),
        'title' => $_POST['title'],
        'content' => $_POST['editor_content'],
        'seo_title' => $_POST['seo_title'],
        'seo_desc' => $_POST['seo_desc'],
        'visibility' => $_POST['visibility']
    ], $id);

    header('Location: /blogez2/konto/post/edit/' . $id);
    exit();
}

$post = new PostController();
$post = $post->getPost($id);
?>

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
                    <h1 class="card-title mb-4 fw-bold">Edycja wpisu</h1>

                    <form id="editForm" action="/blogez2/konto/post/edit/<?= $post->getId() ?>" method="POST">
                        <ul class="nav nav-tabs mb-4" id="postTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Podstawowe</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="postTabsContent">
                            <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                <div class="mb-4">
                                    <label class="form-label fw-medium" for="title">Nazwa wpisu</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-heading"></i></span>
                                        <input type="text" class="form-control form-control-lg" name="title" id="title" placeholder="Wpisz tytuł..." value="<?= $post->getTitle() ?>">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium">Treść wpisu</label>
                                    <div id="editor" class="form-control" style="min-height: 300px;">
                                        <?= $post->getContent() ?>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium">Widoczność wpisu</label>
                                    <select class="form-select" name="visibility" id="visibility">
                                        <option value="1" <?= $post->getVisibility() == 1 ? 'selected' : '' ?>>Publiczny</option>
                                        <option value="0" <?= $post->getVisibility() == 0 ? 'selected' : '' ?>>Prywatny</option>
                                    </select>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="mb-4">
                                    <label class="form-label fw-medium" for="seo_title">SEO tytuł</label>
                                    <input type="text" class="form-control" name="seo_title" id="seo_title" value="<?= $post->getSeoTitle() ?>">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium" for="seo_desc">SEO opis</label>
                                    <textarea class="form-control" name="seo_desc" id="seo_desc" rows="3"><?= $post->getSeoDesc() ?></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="editor_content" id="editor_content">

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger btn-lg px-4" onclick="confirmAndDelete()">Usuń wpis</button>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="/blogez2/konto/" class="btn btn-light btn-lg px-4">Anuluj</a>
                                <button type="submit" class="btn btn-primary btn-lg px-4" onclick="setEditorContent()">Zapisz zmiany</button>
                            </div>
                        </div>
                    </form>

                    <form id="deleteForm" action="/blogez2/konto/post/edit/<?= $post->getId() ?>" method="POST" style="display: none;">
                        <input type="hidden" name="action" value="delete">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    function setEditorContent() {
        const editorContent = document.querySelector('#editor_content');
        editorContent.value = quill.root.innerHTML;
    }

    function confirmAndDelete() {
        if (confirm('Czy na pewno chcesz usunąć ten wpis?')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>