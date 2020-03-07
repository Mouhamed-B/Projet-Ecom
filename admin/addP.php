  <?php
  $id = null;
  $libelle = null;
  $idcat = null;
  $caract = null;
  $prix = null;
  $stock = null;
  $img=null;
  if (isset($_POST['displayP'])):
    $id = $_POST['displayP'];
    $toModQuery = getProduct($bdd, $id);
    $toMod = $toModQuery->fetch();
    $toModQuery->closeCursor();
    $libelle = $toMod['libelle'];
    $idcat = $toMod['idcat'];
    $caract = $toMod['caract'];
    $prix = $toMod['prix'];
    $stock = $toMod['stock'];
    $img = $toMod['img'];
  endif; 
  ?>
  <div class="container align-content-center ">
    <form class="" method="post" enctype="multipart/form-data" action="scripts/<?=isset($_POST['displayP'])?"modify.php":"insert.php"?>">
      <div class="form-group">
        <label for="libelle">Libelle :</label>
        <input type="text" name="libellep" value="<?=$libelle?>" id="libelle" class="form-control">
      </div>      
      <div class="form-row">
        <div class="form-group mr-2">
          <label for="cat">Categorie :</label>
          <select id="cat" required name="idcat" class="custom-select">
            <?php $response = getCategory($bdd);
            while ($list=$response->fetch()) :?>
              <option value="<?=$list['idcat']?>" <?=($list['idcat']==$idcat)?"selected":null?>><?=$list['libellecat']?></option>
            <?php endwhile;
            $response->closeCursor();?>
          </select>
        </div>
        <div class="form-group mr-2">
          <label for="prix">Prix :</label>
          <div class="input-group">
            <input type="number" name="prix" value="<?=$prix?>" id="prix" class="form-control">
            <div class="input-group-append"><span class="input-group-text">F CFA</span></div>
          </div>
        </div>
        <div class="form-group">
          <label for="stock">Stock :</label>
          <input type="number" name="stock" id="stock" value="<?=$stock?>" class="form-control">
        </div>
      </div> 
      <div class="form-group">
        <label for="file">Photo : </label>
        <input type="file" name="fileToUpload" class="form-control-file" value="../images/<?=$img?>" <?=!isset($_POST['displayP'])?"required":null?> id="file">
      </div>     
      <div class="form-group">
        <label for="caract">Carateristiques :</label>
        <textarea required class="form-control" id="caract" name="caract" rows="5"><?=$caract?></textarea>
      </div>
      <button type="submit" class="btn btn-primary" name="<?=isset($_POST['displayP'])?"modP":"insertP"?>" value="<?=$id?>"> Valider </button><br>
    </form>
    <?php if (isset($_SESSION['mod']) and $_SESSION['mod']==true) : ?>
      <br><div class="alert alert-success text-center col-3 offset-3">Produit Modifié Avec Succès</div>
    <?php endif?>
  </div>