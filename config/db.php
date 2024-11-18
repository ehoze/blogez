<?php
class Database extends PDO {
    private $host = "localhost";
    private $db_name = "blogez_php";
    private $username = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Połączono z bazą danych!";
        } catch (PDOException $e) {
            echo "Błąd połączenia: " . $e->getMessage();
        }
    }

    // Funkcja getConnection, która zwraca obiekt PDO, gdy chcemy wykonać zapytanie
    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection = null;
        echo "Połączenie z bazą danych zostało zamknięte.";
    }
}
