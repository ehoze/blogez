<?php 
class SessionController {
    // Właściwość prywatna do przechowywania informacji o sesji
    private $session = [];

    // Konstruktor klasy
    public function __construct() {
        // Inicjalizacja właściwości $session przy użyciu metody Session
        $this->session = $this->Session();
    }

    // Metoda do zarządzania sesją
    public function Session() {
        // Sprawdzenie, czy istnieje zmienna sesyjna "user_id" i czy nie jest pusta
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
            // Przypisanie wartości "user_id" do zmiennej $session
            $this->session['user_id'] = $_SESSION["user_id"];
        }
        // Przypisanie wartości "is_logged" do zmiennej $session
        $this->session['is_logged'] = $_SESSION['is_logged'] ?? false;

        // Zwrócenie zmiennej $session
        return $this->session;
    }

    // Metoda sprawdzająca, czy użytkownik jest zalogowany
    public function IsLogged() {
        // Sprawdzamy, czy is_logged w sesji obiektu ma wartość true
        return isset($this->session['is_logged']) && $this->session['is_logged'];
    }

    public function GetUserId() {
        if($this->IsLogged()){
            return isset($this->session['user_id']) ? $this->session['user_id'] : false;
        }
    }

    public function GetUserPostsLeft(){
        if($this->IsLogged()){
            $this->session['posts_left'] = $_SESSION["posts_left"];
            return $this->session['posts_left'];
        }
    }

    public function SessionDestroy(){
        unset($_SESSION);
        session_destroy();
        session_write_close();
    }
}

