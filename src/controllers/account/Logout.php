<?php
class Logout
{
    public function __construct() {}

    public function logout()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
        session_write_close();
        header('Location: /blogez2/');
        die;
    }
}
