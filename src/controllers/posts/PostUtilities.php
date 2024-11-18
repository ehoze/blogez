<?php
class PostUtilities extends PostsController
{

    public static function get_post_type($post_id)
    {
        // $post_type = get_post_type($post_id);
        // if ($post_type == "") {
        //     return "";
        // } elseif ($post_type == "") {
        //     return "";
        // }
    }





    public function PostUExcerpt($id)
    {
        $postController = new PostsController();
        $post = $postController->getPost($id);

        // Pobranie treści posta
        $content = $post['content'];

        // Split tags, żeby pozbyć się syfu
        $content = strip_tags($content);

        // Podział treści na słowa
        $words = explode(' ', $content);

        // Sprawdzenie, czy liczba słów przekracza 80
        if (count($words) > 40) {
            // Utworzenie skrótu z pierwszych 80 słów
            $excerpt = implode(' ', array_slice($words, 0, 40)) . '...';
        } else {
            // Jeśli liczba słów jest mniejsza lub równa 80, użyj całej treści
            $excerpt = $content;
        }

        return $excerpt;
        
    }
}
