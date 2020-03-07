<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" type="text/css" href="../css/all.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="../css/style.css">

  <title><?=$title?></title>
</head>
<body>
  <div id="contenu" class="m-auto shadow-lg rounded">
    <div class="row">
      <a href="/"><button class=" offset-sm-2 btn-lg btn btn-outline-primary" id="home" type="button">Acceuil</button></a>
      <h1 class="offset-5" id="adm">Administration</h1>
      <form method="post"  action="../session/sign.php">
      <a href="#"><button id="off" name="signout" class="btn-lg offset-4 ml-3 btn btn-outline-danger align-content-end" type="submit">Deconnexion</button></a>   
      </form> 
    </div>
    <hr>
    <div class="row">
      <div class="col-md-2 col-sm-12 menu">
        <div class="nav flex-column nav-justified nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link active" id="v-pills-users-tab" data-toggle="pill" href="#v-pills-users" role="tab" aria-controls="v-pills-users" aria-selected="true">Utilisateurs</a>
          <a class="nav-link" id="v-pills-products-tab" data-toggle="pill" href="#v-pills-products" role="tab" aria-controls="v-pills-products" aria-selected="false">Produits</a>
          <a class="nav-link" id="v-pills-categories-tab" data-toggle="pill" href="#v-pills-categories" role="tab" aria-controls="v-pills-categories" aria-selected="false">Categories</a>
          <a class="nav-link disabled" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Statistiques</a>
        </div>
      </div>