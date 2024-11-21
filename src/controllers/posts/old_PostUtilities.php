<?php
require_once "./src/controllers/PostController.php";

class PostUtilities {
    private $postController;

    public function __construct() {
        $this->postController = new PostController();
    }

    public static function get_post_type($post_id) {
        return "";
    }

    public function PostUExcerpt($id) {
        $post = $this->postController->getPost($id);
        if (!$post) return '';

        // Pobranie treści posta z obiektu PostModel
        $content = $post->getContent();

        // Split tags, żeby pozbyć się syfu
        $content = strip_tags($content);

        // Podział treści na słowa
        $words = explode(' ', $content);

        // Sprawdzenie, czy liczba słów przekracza 40
        if (count($words) > 40) {
            // Utworzenie skrótu z pierwszych 40 słów
            $excerpt = implode(' ', array_slice($words, 0, 40)) . '...';
        } else {
            // Jeśli liczba słów jest mniejsza lub równa 40, użyj całej treści
            $excerpt = $content;
        }

        return $excerpt;
    }
}
