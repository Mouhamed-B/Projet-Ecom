<?php
if (isset($_POST['deleteU'])) :
	require '../../database/connexion.php';
	$iduser = $_POST['deleteU'];
	$requete = $bdd->prepare("DELETE FROM user WHERE iduser=:iduser");
	try {
		$requete->execute(array(
			'iduser' => $iduser
			)
		);
	} catch (PDOException $e) {
		die("Erreur lors de la suppression du client :".$e->getMessage());
	}
elseif (isset($_POST['deleteC'])) :
	require '../../database/connexion.php';
	$idcat = $_POST['deleteC'];
	$requete = $bdd->prepare("DELETE FROM category WHERE idcat=:idcat");
	try {
		$requete->execute(array(
			'idcat' => $idcat
			)
		);
	} catch (PDOException $e) {
		die("Erreur lors de la suppression du fournisseur :".$e->getMessage());
	}

endif;
echo "<script type='text/javascript'> document.location = '/admin'</script>";
?>