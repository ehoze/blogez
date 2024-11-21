<?php 
require_once('./src/controllers/posts/AccountPosts.php');
class AuthorizationService
{
    private $session;
    
    public function __construct(SessionController $session)
    {
        $this->session = $session;
    }
    
    public function canEditPost(int $postId): bool
    {
        if (!$this->session->IsLogged()) {
            return false;
        }
        
        $accountPosts = new AccountPosts();
        return !$accountPosts->checkPostOwnership($postId, $this->session->GetUserId());
    }
    
    public function requirePostEditPermission(int $postId): void
    {
        if (!$this->canEditPost($postId)) {
            $_SESSION['info_message'] = "Nie masz uprawnień do edycji tego wpisu!";
            header('Location:/blogez2/konto/', true, 301);
            exit();
        }
    }
}