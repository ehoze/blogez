<?php 
session_start(); 

require_once("db.php");  // Dołączamy plik z bazą danych
require_once './src/controllers/SessionController.php';  // Dołączamy kontroler sesji

$SES = new SessionController();

?>
