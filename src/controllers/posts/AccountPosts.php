<?php
@include_once 'config/db.php';
@include_once '../../config/db.php';

class AccountPosts
{
    private $db;

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
    public function addPost($params)
    {
        $connection = $this->db->getConnection();

        if (empty($params['title']) || empty($params['content'])) {
            echo "Tytuł i treść są wymagane!";
            return false;
        }

        $sql = "INSERT INTO posts (user_id, title, content, seo_title, seo_desc, slug) VALUES (:user_id, :title, :content, :seo_title, :seo_desc, :slug)";

        // Generowanie "slug" z tytułu
        $slug = $this->generateSlug($params['title']);

        // Przygotowanie zapytania
        $stmt = $connection->prepare($sql);

        try {
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':title' => $params['title'],
                ':content' => $params['content'], 
                ':seo_title' => $params['seo_title'] ?? null,
                ':seo_desc' => $params['seo_desc'] ?? null,
                ':slug' => $slug
            ]);
            echo "Wpis został dodany pomyślnie!";

            $postsLeft = --$_SESSION['posts_left'];
            $sql = "UPDATE users SET max_posts = :postsLeft WHERE id = :user_id";
            $stmt = $connection->prepare($sql);
            $stmt->execute([':postsLeft' => $postsLeft, ':user_id' => $_SESSION['user_id']]);

            header('Location:http://localhost/blogez2/konto/', true, 301);
            return true;
        } catch (PDOException $e) {
            echo "Błąd podczas dodawania wpisu: " . $e->getMessage();
            return false;
        }
    }

    // Edytowanie wpisu
    public function editPost($params, $id)
    {
        $connection = $this->db->getConnection();

        $sql = "UPDATE posts SET title = :title, content = :content, seo_title = :seo_title, seo_desc = :seo_desc WHERE id = :id";
        $stmt = $connection->prepare($sql);

        try {
            $stmt->execute([
                ':id' => $id,
                ':title' => $params['title'],
                ':content' => $params['content'], 
                ':seo_title' => $params['seo_title'],
                ':seo_desc' => $params['seo_desc']
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
