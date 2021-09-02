<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Administrador</title>
  </head>
  <body>
<header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
    <img src="../logo.png" height="40" class="d-inline-block align-top" alt="" loading="lazy">
            Administrador
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="eventos.php">Eventos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pessoas.php">Inscrições</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="config.php">Controles</a>
      </li>
    </ul>
    <span class="navbar-text">
    <form class="form-inline" method="POST" action="login.php">
            <?php
            if(isset($login_cookie)){
            ?>
                <input type="submit" class="btn btn-danger my-2 my-sm-0"  value="SAIR" id="sair" name="sair"><br>
            <?php
            }
            else{
                echo"<br><a class='btn btn-success my-2 my-sm-0' href='login.html'>Faça Login</a>";
            }
            ?>
        </form>
    </span>
  </div>
</nav>
</header>