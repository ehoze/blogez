<?php
// Import
require_once($_SERVER['DOCUMENT_ROOT'] . '/blogez2/src/controllers/SessionController.php');
/* 
Kontroler usuwania konta
Odpowiedzialny za:
- usuwanie wpisów
- usuwanie konta
- zakończenie sesji
*/
class DeleteAccount
{

    // Zmienne
    private $SES;
    private $db;
    public function __construct()
    {
        $this->SES = new SessionController();
        $this->db = new Database();
    }
    public function index()
    {
        $this->deletePosts();
        $this->deleteAccount();
        $this->logout();
    }

    // Usuwanie wpisów
    private function deletePosts()
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM posts WHERE user_id = :user_id");
        return $stmt->execute([':user_id' => $this->SES->GetUserId()]);
    }

    // Usuwanie konta
    private function deleteAccount()
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $this->SES->GetUserId()]);
    }

    // Zakończenie sesji
    private function logout()
    {
        $this->SES->SessionDestroy();
        header('Location: /blogez2/');
        exit();
    }
}
