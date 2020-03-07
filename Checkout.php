<?php
session_start();
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
if(!isset($_SESSION['iduser'])):
  $_SESSION['alert'] = true;
  header("Location:/");
endif;
require 'database/queries.php';
if (isset($_POST['del'])):
    unset($_SESSION['cart'][$_POST['del']]);
    $_SESSION["cart"] = array_values($_SESSION["cart"]);
    $num = $_COOKIE['#cart'.$_SESSION['iduser']];
    $num-=1;
    setcookie('#cart'.$_SESSION['iduser'],false,time()+(3600*24*365));
    setcookie('#cart'.$_SESSION['iduser'],$num,time()+(3600*24*365));
    setcookie('cart#'.$_SESSION['iduser'],json_encode($_SESSION['cart']),time()+(3600*24*365));
    header('Location:Checkout.php');
endif;
$address1=null;
$address2=null;
if($_SESSION['isClient']):
  $clientInfo = getClient($bdd);
  $data=$clientInfo->fetch();
  $clientInfo->closeCursor();
  $address=$data['addresse'];
  explode('|', $address);
  $address1=$address[0];
  $address2=$address[1];
endif;
$title = "LePapyrus - Commande";
$formValidity = false;
$listValidity = false;

if (isset($_POST['to-cart'])) :
  $qte = (int)$_POST['qte'];
  addToCart($_POST['to-cart'], $qte);
  $ref=$_SERVER['HTTP_REFERER'];
  header("Location:$ref");
else :
  require 'header.php';
  ?>
  <div class="container bg-light pb-5">
    <br>
    <h1 align="center">Validation de Votre Commande</h1><br><hr>
    <!-- <div class="row">-->
      <div class="col-12 order-md-4 mb-4 ml-auto mr-auto">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Votre Panier</span>
          <span class="badge badge-secondary badge-pill"><?=(isset($_COOKIE['#cart'.$_SESSION['iduser']])&& isset($_SESSION['nom']))?$_COOKIE['#cart'.$_SESSION['iduser']]:"0"?></span>
        </h4>
        <ul class="list-group mb-3">
          <?php
          $ptotal=0;
          if (isset($_SESSION['cart'])) :            
            foreach ($_SESSION['cart'] as $key=> $value) :
              if (is_object($value)) :
                $id = $value->idproduit;
                $qte = $value->quantite;
              else :
                $id = $value['idproduit'];
                $qte = $value['quantite'];
              endif;
              $queryp = getProduct($bdd, $id);
              $productInfo = $queryp->fetch();
              $product= [
                'libelle'=>$productInfo['libelle'],
                'prix'=>$productInfo['prix'],
                'img'=>$productInfo['img'],
                'libellecat'=>$productInfo['libellecat']
              ];
              $total=$qte*$product['prix'];
              $ptotal+=$total?>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div class="row">
                  <img class="img-thumbnail w-25 d-inline" style="max-width: 150px;" src="images/<?=$product['img']?>" alt="<?=$product['libelle']?>">
                  <div class="col-5">
                    <h6 class="my-0"><?=$product['libelle']?></h6>
                    <small class="text-muted"><?=$product['libellecat']?></small>
                  </div>
                </div>
                <span class="text-muted ml-auto mr-auto">x<?=$qte?></span>
                <span class="text-muted ml-auto mr-auto"><?=$product['prix']?> FCFA</span>
                <strong><?=$total?> FCFA</strong>
                <form method="post"  action="">
                  <a href="#"><button name="del" value="<?=$key?>" class="btn-sm btn btn-outline-danger align-content-end" type="submit">Supprimer</button></a>
                </form>
                </li>
              <?php endforeach?>
              <li class="list-group-item d-flex justify-content-between">
                <span>Total </span>
                <strong><?=$ptotal?> FCFA</strong>
              </li>
              <?php else: ?>
                <h3 class="text-center">Panier Vide</h3>
              <?php endif?> 

            </ul>
          </div>
          <div class="col-md-8 order-md-1 ml-auto mr-auto">
            <h4 class="mb-3">Adresse de Facturation</h4>
            <form class="needs-validation" method="post" action="database/commande.php" novalidate="">
              <div class="mb-3">
                <label for="address">Addresse</label>
                <input type="text" class="form-control" id="address" value="<?=$address?>" name="address1" placeholder="1234 Main St" required="">
                <div class="invalid-feedback">
                  Veuillez donner une adresse de livraison.
                </div>
              </div>

              <div class="mb-3">
                <label for="address2">Addresse Ligne 2 <span class="text-muted">(Optionel)</span></label>
                <input type="text" class="form-control" name="address2" value="" id="address2" placeholder="Apartment or suite">
              </div>
              <hr class="mb-4">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="save-info" class="custom-control-input" id="save-info">
                <label class="custom-control-label" for="save-info">Se Souvenir de cette addresse</label>
              </div>
              <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" type="submit" name="cmd" <?=($ptotal==0)?"disabled":null?>>Valider La commande</button>
            </form>
          </div>
          <!--</div>-->
        </div>
      </div>
    </div>
    <?php require 'footer.php';
  endif;
  ?>