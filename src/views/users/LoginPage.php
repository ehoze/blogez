<?php
if (isset($_SESSION['login_message'])) {
    echo '<div class="my-4 mx-auto w-50 success-message"><p class="p-3 text-light bg-danger border rounded-3">' . $_SESSION['login_message'] . '</p></div>';
    unset($_SESSION['login_message']);
}
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Logowanie</h4>
                </div>
                <div class="card-body p-4">
                    <form action="/blogez2/src/controllers/account/Login.php" method="POST">
                        <div class="mb-4">
                            <label class="form-label" for="name">Nazwa użytkownika</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Wprowadź nazwę użytkownika">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Hasło</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Wprowadź hasło">
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Zaloguj się</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <a href="/blogez2/konto/register" class="btn btn-outline-primary">
                            Nie masz konta? Zarejestruj się
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>