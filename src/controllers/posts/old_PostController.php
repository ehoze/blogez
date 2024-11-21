<?php
require_once 'config/db.php';

class PostsController
{
    private $db;

    public function __construct()
    {
        // $this->db= new Database();
        $this->db = (new Database())->getConnection();
    }

    public function getPost($id)
    {
        $sql = "SELECT * FROM posts WHERE id = :id";
        // $stmt = $this->db->getConnection()->prepare($sql);
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Błąd podczas pobierania postów: " . $e->getMessage();
            return false;
        }
    }

    public function getPostContent($id)
    {
        return $this->getPost($id)["content"];
    }

    public function getPostAuthor($id)
    {
        
        $userid = $this->getPost($id)["user_id"];
        $sql = "SELECT name FROM users WHERE id = :user_id";
        // $stmt = $this->db->getConnection()->prepare($sql);
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([':user_id' => $userid]);
            return $stmt->fetch(    PDO::FETCH_ASSOC)['name'];
        } catch (PDOException $e) {
            echo "Błąd podczas pobierania postów: " . $e->getMessage();
            return false;
        }
    }

    // SEO
    public function getPostSeoTitle($id){
        return $this->getPost($id)["seo_title"];
    }
    public function getPostSeoMetaDesc($id){
        return $this->getPost($id)["seo_desc"];
    }



    public function getPosts($limit = null, $order_direction = 'DESC'){
        $order_direction = strtoupper($order_direction) === 'ASC' ? 'ASC' : 'DESC';
        $sql = "SELECT * FROM posts ORDER BY id $order_direction";
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }
        // $stmt = $this->db->getConnection()->prepare($sql);
        $stmt = $this->db->prepare($sql);
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Błąd podczas pobierania postów: " . $e->getMessage();
            return false;
        }
    }
    


    // public function getPosts()
    // {
    //     // Pobranie wszystkich argumentów przekazanych do funkcji
    //     $args = func_get_args();

    //     // Sprawdzenie, czy argument $limit został przekazany
    //     if (isset($args[0])) {
    //         $limit = $args[0];
    //     } else {
    //         // Jeśli argument $limit nie został przekazany, ustawienie go na null lub inną wartość
    //         $limit = null;
    //     }

    //     $sql = "SELECT * FROM posts ORDER BY id";
    //     $stmt = $this->db->getConnection()->prepare($sql);
    //     try {
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         echo "Błąd podczas pobierania postów: " . $e->getMessage();
    //         return false;
    //     }
    // }





}





/*
<?php 
require_once 'config/db.php';
// @include_once '../../config/db.php';
class PostsController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Zakładamy, że `Database` już tworzy połączenie PDO.
    }


    public function getPost($id)
    {
        $connection = $this->db->getConnection(); // Uzyskujemy obiekt PDO przez metodę `getConnection()`
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $connection->prepare($sql);
        try {
            $stmt->execute([':id' => $id]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($post);
            return $post;
        } catch (PDOException $e) {
            echo "Błąd podczas pobierania postów: " . $e->getMessage();
            return false;
        }
    }

    public function getPosts()
    {
        // Pobranie wszystkich argumentów przekazanych do funkcji
        // $args = func_get_args();

        // // Sprawdzenie, czy argument $limit został przekazany
        // if (isset($args[0])) {
        //     $limit = $args[0];
        // } else {
        //     // Jeśli argument $limit nie został przekazany, ustawienie go na null lub inną wartość
        //     $limit = null;
        // }



        $connection = $this->db->getConnection(); // Uzyskujemy obiekt PDO przez metodę `getConnection()`

        // $sql = "SELECT * FROM posts ORDER BY id :ascdesc limit 4";
        $sql = "SELECT * FROM posts ORDER BY id";


        // Przygotowanie zapytania
        $stmt = $connection->prepare($sql);

        // Wykonanie zapytania
        try {
            // $stmt->execute([':user_id' => $_SESSION['user_id']]);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            echo "Błąd podczas pobierania postów: " . $e->getMessage();
            return false;
        }
    }
}
*/