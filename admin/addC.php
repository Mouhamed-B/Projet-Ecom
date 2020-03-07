  <?php
  $id = null;
  $libelle = null;
  if (isset($_POST['displayC']))
    $id = $_POST['displayC'];
    $libelle = $_POST['libelle'];
  ?>
  <div class="container align-content-center ">
    <form class="" method="post" action="scripts/<?=isset($_POST['displayC'])?"modify.php":"insert.php"?>">      
      <div class="form-row">
        <div class="form-group mr-2" id="move">
          <label for="idcat">Deplacer vers :</label>
          <select id="idcat" required name="idcat" class="custom-select">
            <?php $response = getCategory($bdd);
            while ($list=$response->fetch()) :?>
              <option value="<?=$list['idcat']?>" <?=($list['idcat']==$id)?"selected disabled":null?>><?=$list['libellecat']?></option>
            <?php endwhile;
            $response->closeCursor();?>
          </select>
        </div>
        <div class="form-group ml-2" id="new">
          <label for="libelle">Nouvelle Categorie :</label>
          <input type="text" name="libellec" value="<?=$libelle?>" required id="libellec" class="form-control">
        </div>
      </div>      
      <button type="submit" class="btn btn-primary" name="<?=isset($_POST['displayC'])?"modC":"insertC"?>" value="<?=$id?>"> Valider </button><br>
    </form>
    <?php if (isset($_SESSION['mod']) and $_SESSION['mod']==true) : ?>
      <br><div class="alert alert-success text-center col-3 offset-3">Categories Mises a Jour Avec Succès</div>
    <?php endif?>
  </div>