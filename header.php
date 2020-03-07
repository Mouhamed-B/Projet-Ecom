<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
if (!isset($_SESSION['iduser']))
    $_SESSION['admin']=false;
if (($_SESSION['alert'])):
    $mTitle="Réservé aux utilisateurs";
    $mbody="Veuillez vous inscrire ou vous connecter pour effectuer vos achats";
    $mLink="/session/sign.php";
    $mBtn="Je m'inscris";
elseif (($_GET['validation'])==1):
    $mTitle="Commande Validee avec succes";
    $mbody="Vous serez bientot contacté par un de nos livreurs par mail ou par telephone";
    $mLink="/";
    $mBtn="Continuer";
endif;
?>
<!DOCTYPE html>
<html lang="en" id="html">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <title><?=$title;?></title> 
  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="/css/shop-homepage.css" rel="stylesheet">

  <!-- Font Awesome icons -->
  <link href="/css/all.css" rel="stylesheet">

  <?php
   if ($_SERVER['SCRIPT_NAME']=='/Checkout.php') : ?><link href="css/form-validation.css" rel="stylesheet"> <?php endif?>
</head>

<body id="body">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand ml-md-4 ml-lg-4" href="/"><i class="fas fa-scroll"></i><h4 class="d-inline"> LePapyrus</h4></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <?php if ($formValidity) : ?>
          <form class="mr-auto ml-auto"id="search-form" action="search.php">
            <div class="input-group">
              <div class="input-group-prepend">
                <select class="form-control" name="category" id="prependC">
                  <option id="responsive-option"></option>
                  <?php $response = getCategory($bdd);
                  while ($list=$response->fetch()) :?>
                    <option value="<?=$list['libellecat']?>" class="d-inline-block text-truncate" style="max-width: 30px;"><?=$list['libellecat']?></option>
                  <?php endwhile;
                  $response->closeCursor();?>
                </select>
              </div>
              <input type="text" class="form-control" placeholder="Rechercher un produit..." name="search">
              <div class="input-group-append" id="appendC">
                <button class="btn btn-default" id="responsive-search-btn" type="submit"></button>
              </div>
            </div>
          </form>
        <?php endif;?>
        <ul class="navbar-nav mr-7 ml-auto">
          <li class="nav-item active">
            <div class="dropdown"> 
              <?php if (!isset($_SESSION['nom'])) : ?>

                <span class=" nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=(isset($_SESSION['check']) && $_SESSION['check']==false) ? "<i class=\"fas fa-exclamation-circle\"></i>" :null ?> <i class="fas fa-user"></i> Se Connecter</span>
                <span class="sr-only">(current)</span>
                <div class="dropdown-menu dropdown-menu-left">
                  <form class="px-4 py-3" action="session/sign.php" method="post">
                    <div class="form-group">
                      <label for="logmail">Addresse Email</label>
                      <input type="email" class="form-control" name="email" id="logmail" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                      <label for="logpass">Mot de Passe</label>
                      <input type="password" class="form-control" name="logpass" id="logpass"placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="dropdownCheck">
                        <label class="form-check-label" for="dropdownCheck">
                          Se Souvenir de moi
                        </label>
                      </div>
                    </div>
                    <button type="submit" name="signin"class="btn btn-primary">Se connecter</button>
                  </form>
                  <div class="dropdown-divider"></div>
                  <?=(isset($_SESSION['check']) && $_SESSION['check']==false) ? "<div class=\"alert alert-danger\"> Email ou mot de passe errone</div>
                  <div class=\"dropdown-divider\"></div>" : null?>
                  <a class="dropdown-item" name="signup" href="session/sign.php">Nouveau ici ? S'inscrire</a>
                  <a class="dropdown-item" name="mdpReset" href="sign.php">Mot de Passe Oublié ?</a>
                </div>
                <?php else : ?>
                  <span id="shrink-width"></span>
                  <span class=" nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> <?=$_SESSION['prenom']?></span>
                  <span class="sr-only">(current)</span>
                  <div class="dropdown-menu">
                    <div class="list-group">
                      <a href="/session/profil.php" class="list-group-item hover-active">Mon Profil</a>
                      <?php if($_SESSION['admin']) :?><a href="admin/" class="list-group-item hover-active">Administration</a><?php endif?>
                      <form method="post"  action="session/sign.php">
                        <a id="signout" href="#" class="list-group-item hover-active">Deconnexion</a>
                        <button hidden id="signout" class=" btn btn-default list-group-item hover-active" name="signout">
                        </button>
                      </form>
                    </div>
                  </div>
                <?php endif?>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="help.php"><i class="fas fa-question-circle"></i> Aide</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Checkout.php?"><i class="fas fa-shopping-cart"></i> Panier <span class="badge badge-secondary badge-pill"><?=(isset($_COOKIE['#cart'.$_SESSION['iduser']])&& isset($_SESSION['iduser']))?$_COOKIE['#cart'.$_SESSION['iduser']]:"0"?></span></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <button type="button" hidden id="modal" data-toggle="modal" data-target="#exampleModal">
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Réservé aux utilisateurs<?=$mTitle?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?=$mbody?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button> 
            <a href="<?=$mLink?>"><button type="button" class="btn btn-primary"><?=$mBtn?></button></a>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">

      <div class="row">
        <?php if ($listValidity) : ?>
          <div class="col-lg-3">
            <!--<h1 class="my-4"><i class="fab fa-accusoft"></i> LePapyrus</h1>-->
            <img src="/images/papyrus.png" class="img-fluid">
            <div class="accordion" id="accordionCategory">
              <div class="card">
                <div class="card-header " id="heading1">
                  <h2 class="mb-0">
                    <button class="btn btn-link nav-link " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <h3>Catégories</h3>
                    </button>
                  </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="heading1" data-parent="#accordionCategory">
                  <div class="card-body list-group">
                  <?php
                    $response = getCategory($bdd);
                    while ($list=$response->fetch()) :
                    //$productCat = (isset($product))?($product['libellecat']==$list['libellecat'])?"":"hover-":"hover-";
                      $indexedCat=(isset($product))?$product['libellecat']:((isset($_GET['libelle']))?$_GET['libelle']:null);
                     $productCat =($indexedCat==$list['libellecat'])?"":"hover-";?>
                     <a href="category.php?libelle=<?=$list['libellecat']?>" class="list-group-item nav-link <?=$productCat?>active ">
                      <?=$list['libellecat']?>
                    </a>
                  <?php endwhile;
                  $response->closeCursor()?>

                </div>
                <div class="card-footer"></div>
              </div>
            </div>            
          </div>



        </div>
        <!-- /.col-lg-3 -->
        <?php unset($_SESSION['check']);
      endif ;?>
      

