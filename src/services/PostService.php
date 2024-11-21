<?php
class PostService {
    private $postController;

    public function __construct($postController) {
        $this->postController = $postController;
    }

    public function createExcerpt(string $content, int $wordLimit = 40): string {
        $content = strip_tags($content);
        $words = explode(' ', $content);

        if (count($words) > $wordLimit) {
            return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
        }

        return $content;
    }

    public function formatDate(string $date, string $format = 'd M Y'): string {
        return date($format, strtotime($date));
    }

    public function getPostMetadata(int $postId): array {
        $post = $this->postController->getPost($postId);
        if (!$post) return [];
        
        return [
            'author' => $post->getAuthorName($postId),
            'date' => $this->formatDate($post->getCreatedAt()),
            'excerpt' => $this->createExcerpt($post->getContent())
        ];
    }
}