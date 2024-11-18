<?php
class AccountController {
    public function index() {
        require_once("./src/views/users/AccountPage.php"); // ZROBIĆ PRZEKIEROWANIE JEŚLI ZALOGOWANY
        // echo "DO ZROBIENIA STRONA ACC + SPRAWDZENIE CZY ZALOGOWANY"; // DODAĆ PRZEKIEROWANIE JEŚLI NIE ZALOGOWANY
    }

    public function register() {
        require_once("./src/views/users/RegisterPage.php"); // ZROBIĆ PRZEKIEROWANIE JEŚLI ZALOGOWANY
    }
    public function login() {
        require_once("./src/views/users/LoginPage.php"); // ZROBIĆ PRZEKIEROWANIE JEŚLI ZALOGOWANY
    }

    public function logout() {
        require_once './src/controllers/account/Logout.php';
        $logout = new Logout();
        $logout->logout();
    }


    // POSTS

    public function postcreate() {
        require_once("./src/views/articles/CreatePostPage.php"); // ZROBIĆ PRZEKIEROWANIE JEŚLI NIEZALOGOWANY
    }

    public function postedit($id) {
        require_once("./src/views/articles/EditPostPage.php"); // ZROBIĆ PRZEKIEROWANIE JEŚLI NIEZALOGOWANY
    }


}
?>
