<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Rejestracja</h4>
                </div>
                <div class="card-body p-4">
                    <form action="/blogez2/src/controllers/account/Register.php" method="POST">
                        <div class="mb-4">
                            <label class="form-label" for="name">Nazwa użytkownika</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input minlength="3" maxlength="25" type="text" class="form-control" 
                                    name="name" id="name" placeholder="Wprowadź nazwę użytkownika" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Adres email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" id="email" 
                                    placeholder="nazwa@przyklad.pl">
                            </div>
                            <div class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Nie dzielimy się z nikim twoimi danymi. Pole mail nie jest wymagane, 
                                będzie potrzebne tylko jeśli chciałbyś odzyskać swoje hasło.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Hasło</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" id="password" 
                                    placeholder="Wprowadź hasło" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="isAccept" 
                                    id="isAccept" required>
                                <label class="form-check-label" for="isAccept">
                                    Akceptuję regulamin strony <a href="/" class="text-primary">blogez</a>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Zarejestruj się</button>
                        </div>
                    </form>

                    <?php
                    if (isset($_SESSION['register_message'])) {
                        echo '<div class="alert alert-warning mt-3" role="alert">' . 
                            $_SESSION['register_message'] . '</div>';
                        unset($_SESSION['register_message']);
                    }
                    ?>

                    <div class="text-center mt-4">
                        <a href="/blogez2/konto/login" class="btn btn-outline-primary">
                            Masz już konto? Zaloguj się
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>