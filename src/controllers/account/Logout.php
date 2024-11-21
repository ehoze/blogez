<?php
require_once './src/controllers/SessionController.php';
class Logout
{
    private $sessionController;
    public function __construct() {
        $this->sessionController = new SessionController();
    }

    public function logout()
    {
        $this->sessionController->SessionDestroy();
        header('Location: /blogez2/');
        die;
    }
}
