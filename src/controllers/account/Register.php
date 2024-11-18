<?php
require_once __DIR__ . '/../../../config/db.php';
class Register
{

    public function __construct() {}

    public function register($params = [])
    {

        // Walidacja danych
        session_start();

        $name = trim($params["name"]);
        $email = isset($params["email"]) ? trim($params["email"]) : null;
        $password = trim($params["password"]);
        $accept = isset($params["isAccept"]) ? trim($params["isAccept"]) : false;

        if (empty($name) || empty($password)) {
            $_SESSION['register_message'] = 'Nie uzupełniono wszystkich wymaganych danych: login - hasło.';
            header('Location:http://localhost/blogez/konto/register', true, 301);
            return false;
        }

        if (!$accept) {
            $_SESSION['register_message'] = 'Nie zaakceptowano regulaminu.';
            header('Location:http://localhost/blogez/konto/register', true, 301);
            return false;
        }


        try {
            $db = new Database();
            $connection = $db->getConnection();


            $stmt = $connection->prepare("SELECT name FROM users WHERE name LIKE :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $result = $stmt->rowCount();
            if ($result >= 1) {
                $_SESSION['register_message'] = 'Użytkownik o tej nazwie już istnieje!';
                header('Location:http://localhost/blogez2/konto/register', true, 301);
                return false;
            }

            $stmt = $connection->prepare("INSERT INTO users (name, mail, password) VALUES (:name, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);


            $stmt->execute();

            $_SESSION['register_message'] = 'Rejestracja udana!';

            header('Location:http://localhost/blogez2/konto/register', true, 301);
            return true;
        } catch (PDOException $e) {
            echo 'Nie zostałeś zarejestrowany: ' . $e->getMessage();
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register = new Register();
    $register->register($_POST);
}
