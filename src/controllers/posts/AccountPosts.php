<?php
include_once __DIR__ . '/../../../config/db.php';

class AccountPosts
{
    private $db;
    private const REDIRECT_PATH = '/blogez2/konto/';

    public function __construct()
    {
        $this->db = new Database(); // Zakładamy, że `Database` już tworzy połączenie PDO.
    }

    public function getPosts()
    {
        $connection = $this->db->getConnection(); // Uzyskujemy obiekt PDO przez metodę `getConnection()`

        $sql = "
            SELECT 
                posts.id, posts.title, posts.content, posts.seo_title, posts.seo_desc, posts.slug, posts.user_css,
                users.name AS author_name, users.mail AS author_email
            FROM 
                posts
            INNER JOIN 
                users ON posts.user_id = users.id
            WHERE 
                posts.user_id = :user_id
            ORDER BY 
                posts.id DESC
        ";


        // Przygotowanie zapytania
        $stmt = $connection->prepare($sql);

        // Wykonanie zapytania
        try {
            $stmt->execute([':user_id' => $_SESSION['user_id']]);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            echo "Błąd podczas pobierania postów: " . $e->getMessage();
            return false;
        }
    }

    
    // Tworzenie nowego wpisu
    public function addPost(array $params): bool
    {
        try {
            // Walidacja w osobnej metodzie
            if (!$this->validatePostData($params)) {
                return false;
            }

            $connection = $this->db->getConnection();
            $connection->beginTransaction();

            $slug = $this->generateSlug($params['title']);
            $userId = $this->getUserId();

            // Dodanie posta
            $postAdded = $this->insertPost($connection, [
                'user_id' => $userId,
                'title' => $params['title'],
                'content' => $params['content'],
                'seo_title' => $params['seo_title'] ?? null,
                'seo_desc' => $params['seo_desc'] ?? null,
                'slug' => $slug
            ]);

            if ($postAdded) {
                // Aktualizacja licznika postów
                $this->updateUserPostsCount($connection, $userId);
                $connection->commit();
                $this->setSuccessMessage("Post został dodany pomyślnie!");
                $this->redirect(self::REDIRECT_PATH);
                return true;
            }

            throw new Exception("Nie udało się dodać posta");

        } catch (Exception $e) {
            $connection->rollBack();
            $this->setErrorMessage("Błąd podczas dodawania wpisu: " . $e->getMessage());
            return false;
        }
    }

    private function validatePostData(array $params): bool
    {
        if (empty($params['title']) || empty($params['content'])) {
            $this->setErrorMessage("Tytuł i treść są wymagane!");
            $this->redirect(self::REDIRECT_PATH . 'post/');
            return false;
        }
        return true;
    }

    private function insertPost(PDO $connection, array $data): bool
    {
        $sql = "INSERT INTO posts (user_id, title, content, seo_title, seo_desc, slug, created_at) 
                VALUES (:user_id, :title, :content, :seo_title, :seo_desc, :slug, NOW())";
        
        $stmt = $connection->prepare($sql);
        return $stmt->execute($data);
    }

    private function updateUserPostsCount(PDO $connection, int $userId): void
    {
        $postsLeft = --$_SESSION['posts_left'];
        $sql = "UPDATE users SET max_posts = :postsLeft WHERE id = :user_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute([':postsLeft' => $postsLeft, ':user_id' => $userId]);
    }

    private function setSuccessMessage(string $message): void
    {
        $_SESSION['edit_message'] = $message;
        $_SESSION['edit_message_color'] = "success";
    }

    private function setErrorMessage(string $message): void
    {
        $_SESSION['edit_message'] = $message;
        $_SESSION['edit_message_color'] = "danger";
    }

    private function getUserId(): int
    {
        return $_SESSION['user_id'] ?? throw new Exception("Użytkownik nie jest zalogowany");
    }

    private function redirect(string $path): void
    {
        header('Location: http://localhost' . $path, true, 301);
        exit;
    }

    // Edytowanie wpisu
    public function editPost($params, $id)
    {
        $connection = $this->db->getConnection();

        $sql = "UPDATE posts SET title = ?, content = ?, seo_title = ?, seo_desc = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);

        try {
            $stmt->execute([
                $params['title'],
                $params['content'], 
                $params['seo_title'],
                $params['seo_desc'],
                $id,
            ]);
            $_SESSION['edit_message'] = "Wpis został edytowany pomyślnie!";
            $_SESSION['edit_message_color'] = "success";
            header('Location:http://localhost/blogez2/konto/', true, 301);
            return true;
        } catch (PDOException $e) {
            $_SESSION['edit_message'] = "Wystapił błąd - wpis nie został edytowany!";
            $_SESSION['edit_message_color'] = "danger";
            header('Location:http://localhost/blogez2/konto/', true, 301);
            // echo "Błąd podczas dodawania wpisu: " . $e->getMessage();
            return false;
        }

    }

    public function deletePost($postId, $userId) {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT id from posts WHERE id = ? AND user_id = ?");
            $stmt->execute([$postId, $userId]);

            // Sprawdzenie czy wpis istnieje i czy należy do użytkownika
            if ($stmt->rowCount() === 0){
                $_SESSION['edit_message'] = "Nie masz uprawnień do usuwania tego wpisu!";
                $_SESSION['edit_message_color'] = "danger";
                throw new Exception("Nie masz uprawnień do usuwania tego wpisu!");
            }
            
            // Usuwanie wpisu
            $stmt = $this->db->getConnection()->prepare("DELETE FROM posts WHERE id = ?");
            $stmt->execute([$postId]);

            $stmt = $this->db->getConnection()->prepare("UPDATE users SET max_posts = ? WHERE id = ?");
            $postsLeft = ++$_SESSION['posts_left'];
            $stmt->execute([$postsLeft, $userId]);
            header('Location:http://localhost/blogez2/konto/', true, 301);
            return true;
        } catch (Exception $e) {
            $_SESSION['edit_message'] = $e->getMessage();
            $_SESSION['edit_message_color'] = "danger";
            return false;
        }
    }



    // Metoda do generowania przyjaznego "slug" z tytułu
    private function generateSlug($title)
    {
        // Zamień znaki diakrytyczne na odpowiedniki bez znaków diakrytycznych
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
        
        // Konwertuj na małe litery, usuń białe znaki na początku i końcu
        $slug = strtolower(trim($slug));
        
        // Zamień wszystkie znaki nie będące literami i cyframi na "-"
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        
        // Usuń ewentualne nadmiarowe myślniki na początku i końcu
        $slug = trim($slug, '-');
        
        return $slug;
    }

}
