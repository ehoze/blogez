<?php
require_once './src/models/PostModel.php';
require_once './config/db.php';
require_once __DIR__ . '/SessionController.php';

class PostController {
    private $postModel;
    private $db;
    private $session;
    private const REDIRECT_PATH_ACCOUNT = '/blogez2/konto/';

    public function __construct() {
        $this->postModel = new PostModel();
        $this->db = new Database();
        $this->session = new SessionController();
    }

    // View methods
    public function index() {
        global $postController;
        require_once('./src/views/articles/list.php');
    }

    public function single($id) {
        $post = $this->postModel->load($id);
        if ($post) {
            require_once('./src/views/articles/single.php');
        } else {
            $this->setErrorMessage('Post nie istnieje');
            header('Location: /blogez2/wpisy');
        }
    }

    // Core post methods
    public function getPost($id) {
        return $this->postModel->load($id) ? $this->postModel : false;
    }

    public function getPosts($limit = null) {
        return PostModel::getAll($limit);
    }

    public function getPostAuthor($id) {
        $post = $this->getPost($id);
        return $post ? $post->getAuthorName($id) : false;
    }

    public function getUserPosts($userId = null) {
        $userId = $userId ?? $this->session->GetUserId();
        
        $sql = "
            SELECT 
                posts.id, posts.title, posts.content, posts.seo_title, posts.seo_desc, 
                posts.slug, posts.user_css, users.name AS author_name
            FROM posts
            INNER JOIN users ON posts.user_id = users.id
            WHERE posts.user_id = :user_id
            ORDER BY posts.id DESC
        ";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->setErrorMessage("Błąd podczas pobierania postów: " . $e->getMessage());
            return false;
        }
    }

    public function createPost(array $params) {
        try {
            $connection = $this->db->getConnection();
            $connection->beginTransaction();
            
            if (!$this->validatePostData($params)) {
                throw new Exception("Nieprawidłowe dane posta");
            }

            $userId = $this->session->GetUserId();
            if (!$this->canCreatePost($userId)) {
                throw new Exception("Przekroczono limit dostępnych postów");
            }

            $postData = [
                'user_id' => $userId,
                'title' => $params['title'],
                'content' => $params['content'],
                'seo_title' => $params['seo_title'] ?? '',
                'seo_desc' => $params['seo_desc'] ?? '',
                'slug' => $this->generateSlug($params['title'])
            ];

            $result = $this->postModel->create($postData);
            
            if ($result) {
                $this->updateUserPostsCount($connection, $userId, -1);
                $connection->commit();
                $this->setSuccessMessage("Post został dodany!");
                return true;
            }

            throw new Exception("Nie udało się dodać posta");

        } catch (Exception $e) {
            if (isset($connection)) $connection->rollBack();
            $this->setErrorMessage("Błąd podczas dodawania posta: " . $e->getMessage());
            return false;
        }
    }

    public function updatePost(array $params, int $postId) {
        try {
            if (!$this->canEditPost($postId, $params['user_id'])) {
                throw new Exception("Brak uprawnień do edycji tego posta");
            }

            if (!$this->validatePostData($params)) {
                throw new Exception("Nieprawidłowe dane posta");
            }

            $result = $this->postModel->update($params, $postId);
            
            if ($result) {
                $this->setSuccessMessage("Post został zaktualizowany!");
                return true;
            }

            throw new Exception("Nie udało się zaktualizować posta");

        } catch (Exception $e) {
            $this->setErrorMessage("Błąd podczas aktualizacji: " . $e->getMessage());
            return false;
        }
    }

    public function deletePost($postId, $userId) {
        try {
            $connection = $this->db->getConnection();
            $connection->beginTransaction();

            if (!$this->canEditPost($postId, $userId)) {
                throw new Exception("Brak uprawnień do usunięcia tego posta");
            }

            $result = $this->postModel->delete($postId);
            
            if ($result) {
                $this->updateUserPostsCount($connection, $userId, 1);
                $connection->commit();
                $this->setSuccessMessage("Post został usunięty!");
                return true;
            }

            throw new Exception("Nie udało się usunąć posta");

        } catch (Exception $e) {
            if (isset($connection)) $connection->rollBack();
            $this->setErrorMessage("Błąd podczas usuwania: " . $e->getMessage());
            return false;
        }
    }

    // Helper methods
    private function canEditPost(int $postId, int $userId): bool {
        return !$this->postModel->checkPostOwnership($postId, $userId);
    }

    private function canCreatePost(int $userId): bool {
        return $this->session->GetUserPostsLeft() > 0;
    }

    private function validatePostData(array $params): bool {
        return !empty($params['title']) && !empty($params['content']);
    }

    private function generateSlug(string $title): string {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return substr($slug, 0, 50);
    }

    private function updateUserPostsCount($connection, $userId, $change) {
        $sql = "UPDATE users SET max_posts = max_posts + :change WHERE id = :user_id";
        $stmt = $connection->prepare($sql);
        return $stmt->execute([':change' => $change, ':user_id' => $userId]);
    }

    private function setSuccessMessage(string $message): void {
        $_SESSION['edit_message'] = $message;
        $_SESSION['edit_message_color'] = 'success';
    }

    private function setErrorMessage(string $message): void {
        $_SESSION['edit_message'] = $message;
        $_SESSION['edit_message_color'] = 'danger';
    }

    private function redirect(string $path): void {
        header("Location: $path", true, 301);
        exit();
    }
}