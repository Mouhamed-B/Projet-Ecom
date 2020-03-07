<?php
session_start();
$tab="";
if (isset($_POST['modP'])) :
	require '../../database/connexion.php';
	$idProduit = $_POST['modP'];
	$libelle = $_POST['libellep'];
	$idcat = $_POST['idcat'];
	$stock = $_POST['stock'];
	$prix = $_POST['prix'];
	$caract = $_POST['caract'];
	$target_dir = getcwd().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
	$file = basename($_FILES["fileToUpload"]["name"]);
	$target_file = $target_dir . $file;
	if(!file_exists($target_file)) :
		$requete = $bdd->prepare("UPDATE produit SET libelle=:libelle, idcat=:idcat, stock=:stock, prix=:prix, caract=:caract WHERE idProduit=:idProduit");
		try {
		$requete->execute(array(
			'idProduit' => $idProduit,
			'libelle' => $libelle,
			'idcat' => $idcat, 
			'stock' => $stock, 
			'prix' => $prix,
			'caract' => $caract
			)
		);
		} catch (PDOException $e) {
			die("Erreur lors de la mise à jour du produit:".$e->getMessage());	
		}
	else :
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if ($check == false):
			echo "fail a";
			goto a;
		elseif (($_FILES["fileToUpload"]["size"] > 5000000)|| (
		  $imageFileType != "jpg" &&
		  $imageFileType != "png" &&
		  $imageFileType != "jpeg"&&
		  $imageFileType != "gif"
	    )) :
			echo "fail b";
			goto a;
		elseif (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)):
			echo "failed here";
			sleep(5);
			$uploadOk = 0;
			goto a;
		endif;
		$requete = $bdd->prepare("UPDATE produit SET libelle=:libelle, idcat=:idcat, stock=:stock, prix=:prix, img=:img, caract=:caract WHERE idProduit=:idProduit");
		try {
			$requete->execute(array(
				'idProduit' => $idProduit,
				'libelle' => $libelle,
				'idcat' => $idcat, 
				'stock' => $stock, 
				'prix' => $prix,
				'caract' => $caract,
				'img' => $file
				)
			);
		} catch (PDOException $e) {
			die("Erreur lors de la mise à jour du produit:".$e->getMessage());	
		}
	endif;
	
	$_SESSION['mod']==true;
	$tab='v-pills-products';
elseif (isset($_POST['modC'])) :
	require '../../database/connexion.php';
	$idcat = (int)$_POST['modC'];
	$value =(int) $_POST['libellec'];
	if(isset($_POST['idcat'])) :
		$table = 'produit';
		$value = (int)$_POST['idcat'];
		$requete = $bdd->prepare("UPDATE produit SET idcat=:value WHERE idcat=:idcat");
	else :
		$requette = $bdd->prepare("UPDATE category SET libellecat=:value WHERE idcat=:idcat");
	endif;
	try {
		$requete->execute(array(
			'value' =>$value,
			'idcat' => $idcat
		)
	);
	} catch (PDOException $e) {
		die("Erreur lors de la mise à jour de la categorie:".$e->getMessage());	
	}
	$_SESSION['mod']==true;
	$tab = 'v-pills-categories';
endif;
a:
echo "<script type='text/javascript'> document.location = '/admin#".$tab."'; </script>";
//header("Location:/admin/#v-pills-products");
?>