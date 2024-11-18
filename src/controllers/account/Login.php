<?php

require_once __DIR__ . '/../../../config/db.php';
// require_once '../../controllers/SessionController.php';

class Login
{

    public function __construct() {}

    public function login($params = [])
    {

        // Walidacja danych
        session_start();

        $name = trim($params["name"]);
        $password = trim($params["password"]);

        if (empty($name) || empty($password)) {
            echo 'Nie uzupełniono wszystkich danych: login - hasło.';
            return false;
        }

        try {
            $db = new Database();
            $connection = $db->getConnection();

            $stmt = $connection->prepare("SELECT * FROM users WHERE name LIKE :name");

            $stmt->bindParam(':name', $name);
            // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            // $stmt->bindParam(':password', $hashedPassword);


            $stmt->execute();
            echo $stmt->rowCount();
            if ($stmt->rowCount() >= 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                // echo $user['name'];
                // echo $user['password'];
                // echo '<br/>';
                if (password_verify($password, $user['password'])) {
                    $_SESSION['name'] = $name;
                    $_SESSION['is_logged'] = true;
                    $_SESSION['posts_left'] = $user['max_posts'];
                    $_SESSION['user_id'] = $user['id'];


                    $_SESSION['login_message'] = "Witaj {$name}!";

                    header('Location:http://localhost/blogez2/konto/', true, 301);
                    return true;
                }
            }else{
                $_SESSION['login_message'] = 'Niepoprawne dane logowania.';
                header('Location:http://localhost/blogez2/konto/login/', true, 301);
                return false;
            }
        } catch (PDOException $e) {
            echo 'Nie zostałeś zalogowany: ' . $e->getMessage();
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register = new Login();
    $register->login($_POST);
}
