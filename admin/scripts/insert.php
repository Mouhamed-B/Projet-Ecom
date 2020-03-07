<?php
session_start();
$tab="";
if (isset($_POST['insertP'])) :
	$tab='v-pills-products';
	require '../../database/connexion.php';
	$target_dir = getcwd().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
	$file = basename($_FILES["fileToUpload"]["name"]);
	//echo $file;
	$target_file = $target_dir . $file;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if ($check == false ):
		echo "fail a";
		goto a;
	elseif(file_exists($target_file)):
		goto b;
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
	b:
	$idcat = $_POST['idcat'];
	$libelle = $_POST['libellep'];
	$prix = $_POST['prix'];
	$stock = $_POST['stock'];
	$caract = $_POST['caract'];
	$requete = $bdd->prepare("INSERT INTO `produit` (`idcat`, `libelle`, `prix`, `stock`, `img`, `caract`) VALUES (:idcat , :libelle , :prix, :stock, :file, :caract)");
	try {
		$requete->execute(array(
			'idcat' => $idcat,
			'libelle' => $libelle, 
			'prix' => $prix, 
			'file' => $file,
			'stock' => $stock,
			'caract' => $caract
		)
	);
	} catch (PDOException $e) {
		die("Erreur lors de l'insertion du nouveau produit:".$e->getMessage());	
	}
elseif (isset($_POST['insertC'])) :
	require '../../database/connexion.php';
	if (is_null($_POST['libellecat'])) {
		goto a;
	}
	$libellecat = $_POST['libellec'];
	$requete = $bdd->prepare("INSERT INTO category(libellecat) VALUES(:libellecat)");
	try {
		$requete->execute(array(
			'libellecat' => $libellecat
		)
	);
	} catch (PDOException $e) {
		die("Erreur lors de l'insertion de la nouvelle categorie:".$e->getMessage());	
	}
	$tab = 'v-pills-categories';
endif;
a:
echo "<script type='text/javascript'> document.location = '/admin#".$tab."'; </script>";
?>