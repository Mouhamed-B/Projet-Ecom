<?php
session_start();
$formValidity = true;
$listValidity = true;
require 'database/queries.php';
if (isset($_GET['id'])) :
  $id = $_GET['id'];
  $queryp = getProduct($bdd, $id);
  while ($productInfo = $queryp->fetch()) :
    $product= [
    'libelle'=>$productInfo['libelle'],
    'libellecat'=>$productInfo['libellecat'],
    'caract'=>$productInfo['caract'],
    'prix'=>$productInfo['prix'],
    'stock'=>$productInfo['stock'],
    'img'=>$productInfo['img']
    ];
  endwhile;
  $queryp->closeCursor();
  if ($product['stock']==0):
    $stockIfOk = "disabled";
    $stockAlert = "danger";
    $stockMsg = "Stock Epuisé";
  elseif ($product['stock']>0 && $product['stock']<=5):
    $stockIfOk = "";
    $stockAlert = "danger";
    $stockMsg = "Que ".$product['stock']." en Stock";
  else :  
    $stockIfOk = "";
    $stockAlert = "sucess";
    $stockMsg = "Actuellement en stock";
  endif;
  $queryc = getComments($bdd, $id);
endif;
$title = "LePapyrus - ".$product['libelle'];
require 'header.php';
?>
<!-- Page Content -->
<div class="col-9">
  <div class="row ml-1">
   <div class="card mt-4 col-6">
    <img class="card-img-top " src="images/<?=$product['img']?>" alt="">
    <div class="card-body">
      <h3 class="card-title"><?=$product['libelle']?></h3>
    </div>
  </div>
  <!-- /.card -->
  <div class="card mt-4 col-5 ml-1">
    <div class="card-body" style="line-height: 1.5rem;">
      <h3 class="card-title info"><?=$product['prix']?> FCFA TTC</h3><hr>
      <h4 class="info"><?=$product['libellecat']?></h4><hr>
      <p class="card-text info"><?=$product['caract']?></p><hr>
      <form class="mb-5" method="post" action="Checkout.php">
        <div class="form-group form-inline mb-4">
          <label for="qte">Quantite</label>
          <select name="qte" class="custom-select ml-3 d-block w-25" <?=$stockIfOk?>>
            <?php for ($i=1; $i < 5; $i++) : ?>
              <option value="<?=$i?>"><?=$i?></option>
            <?php endfor?>
          </select>
          <span id="stock" class="alert-<?=$stockAlert?> ml-3"><?=$stockMsg?></span>
        </div>
        <button type="submit" class="btn btn-outline-primary" name="to-cart" value="<?=$_GET['id']?>" <?=$stockIfOk?>> Ajouter au Panier</button>
        <button type="submit" class="btn btn-outline-info ml-3" name="to-checkout" value="<?=$_GET['id']?>"<?=$stockIfOk?>>Commander Maintenant</button>
      </form><hr>
      <span class="text-warning mt-2">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
      4.0 stars
    </div>
  </div>
  <!-- /.card -->
</div>
<div id="comments" class="card card-outline-secondary my-4">
  <div class="card-header">
    Product Reviews
  </div>
  <div class="card-body">
    <?php while ($comments=$queryc->fetch()) : ?>
    <p><?=$comments['comment']?></p>
    <small class="text-muted">Posté par <?=$comments['author']?>, le <?=$comments['date']?></small>
    <hr>
  <?php endwhile;
    $queryc->closeCursor();
   ?>
   <?=(isset($_SESSION['nom']))?"":"Connectez-vous pour publier ou creer un compte <a href=\"/session/sign.php\">ici</a><br>"?>
    <form>
      <textarea class="form-control mb-3 mt-2" name="comment" <?=(isset($_SESSION['nom']))?"":"disabled"?>></textarea>
    <a href="#" type="submit" name="review" class="btn btn-success" <?=(isset($_SESSION['nom']))?"":"disabled"?>>Laisser un Commentaire</a>
  </form>
  </div>
</div>
<!-- /.card -->
</div>
<!-- /.col-9 -->

</div>

</div>
<!-- /.container -->
<?php unset($_SESSION['product']);
include 'footer.php';?>
