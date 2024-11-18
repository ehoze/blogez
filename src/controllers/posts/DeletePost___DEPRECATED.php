<?php 
session_start();
global $SES;

if(!$SES->IsLogged()){
    header('Location: /blogez2/konto/login/');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once './src/controllers/posts/AccountPosts.php';

    try{
        $postId = isset($_GET['id']) ? $_GET['id'] : null;
        $userId = $SES->GetUserId();

        $accountPosts = new AccountPosts();
        $accountPosts->deletePost($postId, $userId);


    } catch (Exception $e) {
        $_SESSION['edit_message'] = $e->getMessage();
        $_SESSION['edit_message_color'] = "danger";
    }

    header('Location: /blogez2/konto/');
    exit();
}
// Jeśli ktoś próbuje dostać się bezpośrednio przez GET
header('Location: /blogez2/konto/');
exit();
