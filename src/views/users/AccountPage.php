<?php
global $SES;
(!$SES->IsLogged()) ? header('Location:/blogez2/konto/login/', true, 301) : '';

require_once('./src/controllers/account/DeleteAccount.php');
// Obsługa usuwania konta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deleteAccount' && isset($_POST['confirmation_id'])) {
    $deleteAccount = new DeleteAccount();
    $deleteAccount->index();
    header('Location: /blogez2/konto/');
    exit();
}

require_once('./src/controllers/posts/AccountPosts.php');

$accountPosts = new AccountPosts();
$posts = $accountPosts->getPosts();
?>
<section class="container py-5">
    <?php
    if (isset($_SESSION['login_message'])) {
        echo '<div class="alert alert-success fade show" role="alert">' . $_SESSION['login_message'] . '</div>';
    }
    if (isset($_SESSION['info_message'])) {
        echo '<div class="alert alert-danger fade show" role="alert">' . $_SESSION['info_message'] . '</div>';
        unset($_SESSION['info_message']);
    } ?>

    <h2 class="dashboard-title mb-4">Panel użytkownika</h2>
    <div class="stats-container mb-5">
        <p class="text-muted mb-4">Krótkie podsumowanie statystyk dla twojego konta:</p>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="stats-card">
                    <div class="card-body p-4">
                        <div class="stats-icon mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </div>
                        <h5 class="stats-number"><?= $SES->GetUserPostsLeft() ?></h5>
                        <p class="stats-text">Pozostałych wpisów do wykorzystania</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="stats-card">
                    <div class="card-body p-4">
                        <div class="stats-icon mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                                <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z" />
                            </svg>
                        </div>
                        <h5 class="stats-number">ID: <?= $SES->GetUserId() ?></h5>
                        <p class="stats-text">Identyfikator twojego konta</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="posts-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Twoje wpisy</h2>
            <a href="/blogez2/konto/post/create" class="btn btn-gradient">Dodaj nowy wpis</a>
        </div>

        <?php if ($posts) { ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($posts as $post) { ?>
                    <div class="col">
                        <div class="post-card">
                            <div class="card-body p-4">
                                <h5 class="post-title"><?= htmlspecialchars($post['title']) ?></h5>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="/blogez2/konto/post/edit/<?= $post['id'] ?>" class="btn btn-outline-gradient">
                                        Edytuj wpis
                                    </a>
                                    <form id="deleteForm" action="/blogez2/konto/post/edit/<?= $post['id'] ?>" method="POST">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="button" class="btn btn-danger btn-lg px-4" onclick="confirmAndDelete()">Usuń wpis</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="empty-state text-center py-5">
                <p class="text-muted mb-4">Brak postów do wyświetlenia. Dobrze byłoby od czegoś zacząć:</p>
                <a href="/blogez2/konto/post/create" class="btn btn-gradient">Stwórz swój pierwszy wpis</a>
            </div>
        <?php } ?>
    </div>
</section>

<section class="container py-5">
    <h2 class="section-title">Usuń konto</h2>
    <form id="deleteAccountForm" action="/blogez2/konto/" method="POST">
        <input type="hidden" name="action" value="deleteAccount">
        <button type="button" class="btn btn-danger" onclick="confirmAndDeleteAccount()">Usuń konto</button>
    </form>
</section>

<!-- Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Usuń konto</h5>
                <form id="deleteAccountForm" action="/blogez2/konto/" method="POST">
                    <input type="hidden" name="action" value="deleteAccount">
                    <button type="button" class="btn btn-danger" onclick="confirmAndDeleteAccount()">Usuń konto</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmAndDeleteAccount() {
        if (confirm('Czy na pewno chcesz usunąć swoje konto? Wszystkie twoje wpisy zostaną usunięte. (Ta akcja jest nieodwracalna)')) {
            const form = document.getElementById('deleteAccountForm');
            const confirmationId = Math.random().toString(36).substring(2, 15);
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'confirmation_id';
            hiddenInput.value = confirmationId;
            form.appendChild(hiddenInput);
            document.getElementById('deleteAccountForm').submit();
        }
    }
</script>

<style>
    /* .dashboard-title {
    color: #2d3436;
    font-weight: 700;
    margin-bottom: 2rem;
}

.stats-card {
    background: linear-gradient(145deg, #ffffff, #f5f7fa);
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-icon {
    color: #0984e3;
}

.stats-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3436;
}

.stats-text {
    color: #6c757d;
    margin: 0;
}

.post-card {
    background: linear-gradient(145deg, #ffffff, #f5f7fa);
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.post-card:hover {
    transform: translateY(-5px);
}

.post-title {
    color: #2d3436;
    font-weight: 600;
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

.btn-outline-gradient {
    background: transparent;
    border: 2px solid #0984e3;
    color: #0984e3;
    padding: 8px 20px;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.btn-outline-gradient:hover {
    background: linear-gradient(45deg, #0984e3, #00b894);
    border-color: transparent;
    color: white;
}

.alert {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
} */
</style>

<script>
    function confirmAndDelete() {
        if (confirm('Czy na pewno chcesz usunąć ten wpis?')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>