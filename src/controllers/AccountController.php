<?php
require_once './src/controllers/PostController.php';

class AccountController {
    private $postController;

    public function __construct() {
        $this->postController = new PostController();
    }

    // Account views
    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/blogez2/konto/login');
        }
        require_once("./src/views/users/AccountPage.php");
    }

    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('/blogez2/konto');
        }
        require_once("./src/views/users/RegisterPage.php");
    }

    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('/blogez2/konto');
        }
        require_once("./src/views/users/LoginPage.php");
    }

    public function logout() {
        require_once './src/controllers/account/Logout.php';
        $logout = new Logout();
        $logout->logout();
    }

    // Post management views
    public function postcreate() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/blogez2/konto/login');
        }
        require_once("./src/views/articles/CreatePostPage.php");
    }

    public function postedit($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('/blogez2/konto/login');
        }
        require_once("./src/views/articles/EditPostPage.php");
    }

    public function deletepost($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('/blogez2/konto/login');
        }
        require_once './src/controllers/posts/DeletePost.php';
    }

    // Helper methods
    private function isLoggedIn(): bool {
        return isset($_SESSION['is_logged']) && $_SESSION['is_logged'];
    }

    private function redirect(string $path): void {
        header("Location: $path", true, 301);
        exit();
    }




















    public function accountDelete(){
        require_once './src/controllers/account/DeleteAccount.php';
        $deleteAccount = new DeleteAccount();
        $deleteAccount->deleteAccount();
    }
}
?>
