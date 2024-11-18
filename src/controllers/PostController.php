<?php

class PostController
{
    public function index()
    {
        require_once("./src/views/articles/list.php");
    }

    // Metoda do wyświetlenia pojedynczego wpisu na podstawie ID
    public function single($id)
    {
        // Tu byłby kod do pobierania wpisu z bazy na podstawie $id
        require_once('./src/views/articles/single.php'); // ZROBIENIE OSTYLOWANIA DLA POJEDYŃCZEGO WPISU

    }
}
