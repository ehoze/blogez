<?php // session_start(); ?>
<!doctype html>
<html lang="pl-PL">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blogez - twój lepszy start w blogowaniu</title>
  <?php include_once('./src/views/inc/assets/bootstrap.php'); ?>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/boot/css/bootstrap.css">` -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="http://localhost/blogez2/public/assets/css/maintheme.css">
</head>

<body class="bg-light min-vh-100 d-flex flex-column">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/blogez2">Blogez!</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse container-fluid" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/blogez2/wpisy/">Wpisy</a>
          </li>
          <?php
          if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true) {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Konto
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/blogez2/konto/">Konto</a></li>
                <li><a class="dropdown-item" href="/blogez2/konto/post/">Dodaj wpis</a></li>
              </ul>
            </li>
            <li><a class="nav-link" href="/blogez2/konto/logout">Wyloguj się</a></li>
          <?php
          } else { ?>
            <li><a class="nav-link" href="/blogez2/konto/login">Logowanie</a></li>
            <li><a class="nav-link" href="/blogez2/konto/register">Rejestracja</a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>