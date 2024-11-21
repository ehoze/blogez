<?php
class PostModel {
    private $db;
    private $id;
    private $title;
    private $content;
    private $seo_title;
    private $seo_desc;
    private $user_id;
    private $created_at;
    private $edited_at;
    private $visibility;
    private $excerpt;
    private $featured_image;
    private $slug;


    public function __construct() {
        $this->db = new Database();
    }

    // Podstawowe gettery i settery dla głównych pól
    public function getId() { return $this->id; }
    public function getUserId() { return $this->user_id; }
    public function setUserId($userId) { $this->user_id = $userId; }

    // Gettery i settery dla treści posta
    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }
    public function getContent() { return $this->content; }
    public function setContent($content) { $this->content = $content; }
    public function getVisibility() { return $this->visibility; }
    
    // Gettery i settery dla pól SEO
    public function setSeoTitle($seoTitle) { $this->seo_title = $seoTitle; }
    public function setSeoDesc($seoDesc) { $this->seo_desc = $seoDesc; }

    // Gettery i settery dla dodatkowych funkcjonalności
    public function getExcerpt() {
        if(!$this->excerpt){
            $this->excerpt = substr($this->content, 0, 80) . '...';
        };
        return $this->excerpt; 
    }
    public function setExcerpt($excerpt) { $this->excerpt = $excerpt; }
    // ... pozostałe gettery i settery

    // Metoda do załadowania danych posta
    public function load($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            foreach($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
            return true;
        }
        return false;
    }

    // Metoda do zapisywania posta
    public function save() {
        if ($this->id) {
            return $this->update();
        }
        return $this->insert();
    }

    // Metoda do pobierania wszystkich postów
    public static function getAll($limit = null) {
        $db = new Database();
        $sql = "SELECT * FROM posts WHERE visibility = 1 ORDER BY edited_at DESC, id DESC";
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $db->getConnection()->prepare($sql);
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metoda do usuwania posta
    public function delete() {
        if (!$this->id) return false;
        
        $stmt = $this->db->getConnection()->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute([':id' => $this->id]);
    }

    // Metody do wstawiania i aktualizowania posta
    private function insert() {
        $sql = "INSERT INTO posts (title, content, seo_title, seo_desc, user_id, slug, visibility) 
                VALUES (:title, :content, :seo_title, :seo_desc, :user_id, :slug, :visibility)";
        $stmt = $this->db->getConnection()->prepare($sql);
        
        return $stmt->execute([
            ':title' => $this->title,
            ':content' => $this->content,
            ':seo_title' => $this->seo_title,
            ':seo_desc' => $this->seo_desc,
            ':user_id' => $this->user_id,
            ':slug' => $this->generateSlug(),
            ':visibility' => $this->visibility
        ]);
    }

    private function update() {
        $sql = "UPDATE posts SET 
                title = :title, 
                content = :content,
                seo_title = :seo_title,
                seo_desc = :seo_desc,
                slug = :slug,
                visibility = :visibility
                WHERE id = :id";
                
        $stmt = $this->db->getConnection()->prepare($sql);
        return $stmt->execute([
            ':id' => $this->id,
            ':title' => $this->title,
            ':content' => $this->content,
            ':seo_title' => $this->seo_title,
            ':seo_desc' => $this->seo_desc,
            ':slug' => $this->generateSlug(),
            ':visibility' => $this->visibility
        ]);
    }

    // Generowanie slugu
    private function generateSlug() {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $this->title);
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }
    // Pobieranie autora posta
    public function getAuthorName($id) {
        if (!$this->user_id) return false;
        
        $db = new Database();
        $stmt = $db->getConnection()->prepare("SELECT name FROM users WHERE id = :user_id");
        $stmt->execute([':user_id' => $this->user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['name'] : 'Nieznany autor';
    }

    // Daty
    public function getCreatedAt() {
        return $this->created_at;
    }
    public function getEditedAt() {
        return $this->edited_at;
    }

    // Gettery dla pól SEO
    public function getSeoTitle() {
        return $this->seo_title;
    }

    public function getSeoDesc() {
        return $this->seo_desc;
    }




    // Metoda do pobrania danych jako tablicy asocjacyjnej
    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'seo_title' => $this->seo_title,
            'seo_desc' => $this->seo_desc,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'edited_at' => $this->edited_at,
            'visibility' => $this->visibility,
            'excerpt' => $this->excerpt,
            'featured_image' => $this->featured_image,
            'slug' => $this->slug
        ];
    }
}