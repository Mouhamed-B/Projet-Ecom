<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
session_start();
if (!$_SESSION['admin'])
    header('Location:/');
require '../database/queries.php';
$title = "LePapyrus - Administration";
require 'sidebar.php';
?>
<div class="tab-content col-md-10 col-sm-12" id="v-pills-tabContent">    
  <div class="tab-pane fade show active" id="v-pills-users" role="tabpanel" aria-labelledby="v-pills-users-tab">
    <div class="overflow-auto" style="max-height: 500px;">
      <table width="100%" class="table table-striped">
        <thead class="bg-primary">
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Sexe</th>
            <th scope="col">Date de Naissance</th>
            <th scope="col">Email</th>
            <th scope="col">Telephone</th>   
            <th scope="col">Date Inscription</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $active = "active";
          $users = getUsers($bdd);
          while ($data = $users->fetch()) :?>
            <tr>
              <td><?=$data['nom']?></td>
              <td><?=$data['prenom']?></td>
              <td><?=$data['sexe']?></td>
              <td><?=$data['datenaiss']?></td>
              <td><?=$data['email']?></td>
              <td><?=$data['telephone']?></td>
              <td><?=$data['create_time']?></td>
              <td>
                <form method="post" class="d-inline" action="./scripts/delete.php">
                  <button class="btn btn-outline-danger" name="deleteU" value="<?=$data['iduser']?>">Supprimer</button>
                </form>
                <a class="nav-link d-inline <?=$active?> disabled" id="stat<?=$data['iduser']?>-tab" data-toggle="pill" href="#stat<?=$data['iduser']?>" role="tab" aria-controls="stat<?=$data['iduser']?>" aria-selected="false">
                  <button class="btn btn-outline-info">Voir Stats</button>
                </a>
              </td>
            </tr>
            <?php
            $active = null;
          endwhile ;
          $users->closeCursor();?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="tab-pane fade" id="v-pills-products" role="tabpanel" aria-labelledby="v-pills-products-tab">
    <table id="p" width="100%" class="table table-striped">
      <thead class="bg-primary">
        <tr>
          <th scope="col">Libelle</th>
          <th scope="col">Categorie</th>
          <th scope="col">Prix</th>
          <th scope="col">Stock</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $active = "active";
        $products = getProduct($bdd);
        $aria = "true";
        while ($data = $products->fetch()) :
          if (is_null($active))
            $aria = "false";
          ?>
          <tr>
            <td class="d-inline-block text-truncate"><?=$data['libelle']?></td>
            <td><?=$data['libellecat']?></td>
            <td><?=$data['prix']?></td>
            <td><?=$data['stock']?></td>
            <td>
              <form method="post" class="d-inline" action="./scripts/delete.php">
                <button class="btn btn-outline-danger" name="deleteP" value="<?=$data['idProduit']?>">Supprimer</button>
              </form>
              <a class="nav-link d-inline <?=$active?>" id="mod<?=$data['idProduit']?>-tab" data-toggle="pill" href="#mod<?=$data['idProduit']?>" role="tab" aria-controls="mod<?=$data['idProduit']?>" aria-selected="<?=$aria?>">
                <button class="btn btn-outline-info">Consulter</button>
              </a>
            </td>
          </tr>
          <?php
          $active = null;
        endwhile;
        $products->closeCursor();?>
      </tbody>
    </table>
    <h1 class="text-center"> Contenu </h1> <hr>
    <div class="tab-content" id="mod-tabContent">
      <?php
      $active = "show active";
      $products = getProduct($bdd);
      while ($data = $products->fetch()) :?>
        <div class="tab-pane fade <?=$active?>" role="tabpanel" id="mod<?=$data['idProduit']?>" aria-labelledby="mod<?=$data['idProduit']?>-tab">
          <div class="media">
            <img src="../images/<?=$data["img"]?>" class="img-thumbnail w-25 mr-3" alt="<?=$data['libelle']?>">
            <div class="media-body">
              <h5 class="mt-0"><?=$data['libelle']?></h5>
              <p><?=$data['caract']?></p>
              <form method="post" action="#v-pills-products-tab">
                <button class="btn btn-outline-primary" name="displayP" value="<?=$data['idProduit']?>">Modifier</button>
              </form>
            </div>
          </div>
        </div>
        <?php
        $active = null;
      endwhile;
      $products->closeCursor();?>
    </div>
    <h1 class="text-center mt-2" id="modform"> Ajouter / Modifier </h1> <hr>
    <?php require 'addP.php'; ?>
  </div>
  <div class="tab-pane fade" id="v-pills-categories" role="tabpanel" aria-labelledby="v-pills-categories-tab">
    <table id="c" width="100%" class="table table-striped">
      <thead class="bg-primary">
        <tr>
          <th scope="col">Libelle</th>
          <th scope="col">Produits</th>
          <th scope="col">Stock</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $active = "active";
        $listCat=[];
        $categories = $bdd->query("SELECT p.idcat, libellecat, COUNT(idProduit) as nb, SUM(stock) as st FROM category c, produit p WHERE c.idcat=p.idcat GROUP BY p.idcat ,libellecat");
        while ($data = $categories->fetch()) :
          $listCat["{$data['idcat']}"]=$data['libellecat'] ?>
          <tr>
            <td class="d-inline-block text-truncate"><?=$data['libellecat']?></td>
            <td><?=$data['nb']?></td>
            <td><?=$data['st']?></td>
            <td>
              <form method="post" class="d-inline" action="./scripts/delete.php">
                <button class="btn btn-outline-danger" name="deleteC" value="<?=$data['idcat']?>">Supprimer</button>
              </form>
              <a class="nav-link d-inline
              cat <?=$active?>" id="modc<?=$data['idcat']?>-tab" data-toggle="pill" href="#modc<?=$data['idcat']?>" role="tab" aria-controls="modc<?=$data['idcat']?>" aria-selected="<?=(empty($active))?"false":"true" ?>">
              <button class="btn btn-outline-info">Consulter</button>
            </a>
          </td>
        </tr>
        <?php
        $active = null;
      endwhile;
      $categories->closeCursor();?>
      </tbody>
    </table>
  <h1 class="text-center"> Contenu </h1> <hr>
  <div class="tab-content" id="modContent">
    <?php
    $active = "show active";
    foreach ($listCat as $key => $value) :
      $products = getProduct($bdd,null,$value)?>    
      <div class="tab-pane fade <?=$active?>" id="modc<?=$key?>" role="tabpanel" aria-labelledby="modc<?=$key?>-tab">
        <div class="row">
          <h3 class="col-3"><?=$value?></h3>
          <form method="post" class=" offset-7 col-sm-2" action="">
            <input type="text" name="libelle" value="<?=$value?>" hidden>
            <button class="btn btn-outline-primary" name="displayC" value="<?=$key?>">Modifier</button>
          </form>
        </div>
        <hr class="w-25 align-content-center">
        <?php while ($data = $products->fetch()) :?>
          <div class="media">
            <img src="../images/<?=$data["img"]?>" class="img-thumbnail w-25 mr-3" alt="<?=$data['libelle']?>">
            <div class="media-body">
              <h5 class="mt-0"><?=$data['libelle']?></h5>
              <p><?=$data['caract']?></p>
            </div>
          </div>
          <?php          
        endwhile?>
      </div>
      <?php $active = null;
      $products->closeCursor();
    endforeach ?>
  </div>
  <h1 class="text-center" id="modform"> Ajouter / Modifier </h1> <hr>
  <?php require 'addC.php'; ?>
</div>
</div>
<!-- div.tab-content -->

<?php require 'footer.php' ?>