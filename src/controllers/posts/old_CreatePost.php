<?php
session_start();
require_once 'AccountPosts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountPosts = new AccountPosts();

    // Przekazujemy dane z formularza do metody `addPost`
    $params = [
        // 'user_id' => 1, // Na razie na sztywno, ale w praktyce pobierz `user_id` z sesji zalogowanego użytkownika
        'user_id' => $_SESSION['user_id'], 
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'seo_title' => $_POST['seo_title'],
        'seo_desc' => $_POST['seo_desc']
    ];

    $accountPosts->addPost($params);
}

