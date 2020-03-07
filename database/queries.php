<?php 
require 'connexion.php';

function getCategory($bdd,$id=null)
{
		$category = $bdd->query("SELECT * FROM category") or die("Erreur dans la recuperation des categories ");
		return $category;
}

function getProduct($bdd, $id=null, $libellecat=null)
{
	if (is_null($id)&& is_null($libellecat)):
		$produit = $bdd->query("SELECT * FROM category c INNER JOIN produit p ON p.idcat=c.idcat");
	elseif (is_null($libellecat)) :
		$produit = $bdd->prepare("SELECT * FROM category c INNER JOIN produit p ON p.idcat=c.idcat WHERE idProduit=:id"); 
		try {
			$produit->execute(array('id' => $id));		
		} catch (PDOException $e) {
			echo('Erreur : ' . $e->getMessage()); 
		}
	else :
		$produit = $bdd->prepare("SELECT * FROM produit p INNER JOIN category c ON p.idcat=c.idcat WHERE libellecat=:libellecat"); 
		try {
			$produit->execute(array('libellecat' => $libellecat));		
		} catch (PDOException $e) {
			echo('Erreur : ' . $e->getMessage()); 
		}
	endif;
	return $produit;
}

function createUser($bdd,$email, $passwd, $nom, $pnom, $sexe, $dateNaiss=null, $telephone=null)
{
	$insert = $bdd->prepare("INSERT INTO user(email, password, nom, prenom, sexe, datenaiss, telephone) VALUES (:email, :passwd, :nom, :pnom, :sexe, :datenaiss, :telephone)");
	$insert->execute(array(
		'email' => $email,
		'passwd' => $passwd,
		'nom' => $nom,
		'pnom' => $pnom,
		'sexe' => $sexe,
		'datenaiss' => $dateNaiss,
		'telephone' => $telephone
		)
	) or die (print_r($bdd->errorInfo()));
}

function checkIds($bdd,$email,$passwd){
	$check =false;
	$checkQuery = $bdd->query("SELECT iduser, nom, prenom, email, password FROM user") or die(print_r($bdd->errorInfo));
	while($checkList = $checkQuery->fetch()) :
		if (($checkList['email']==$email) and ($checkList['password'])==$passwd) :
			$check = true;
			$_SESSION['nom']=$checkList['nom'];
			$_SESSION['prenom']=$checkList['prenom'];
			$_SESSION['email']=$checkList['email'];
			$_SESSION['iduser']=$checkList['iduser'];
			$tmp = $bdd->prepare("SELECT idClient FROM client WHERE iduser=:iduser");
			$tmp->execute(array(
				'iduser'=>$_SESSION['iduser']
				)
			);
			$_SESSION['isClient'] = (is_null($tmp->fetch)) ? false:((!($tmp->fetch))?false:true);
			$tmp->closeCursor();
			$_SESSION['admin']=($_SESSION['iduser']==1)?true:false;
			if (isset($_COOKIE['cart#'.$_SESSION['iduser']]))
				$_SESSION['cart']= json_decode($_COOKIE['cart#'.$_SESSION['iduser']]);
			break;
		endif;
	endwhile;
	return $check;
}

function getComments($bdd, $id){
	$comments = $bdd->prepare("SELECT comment, author, date FROM commentaires WHERE idProduit=:id"); 
	try {
		$comments->execute(array('id' => $id));		
	} catch (PDOException $e) {
		echo('Erreur : ' . $e->getMessage()); 
	}
	return $comments;
}

function addClient($bdd, $address)
{
	$client=$bdd->prepare("INSERT INTO client(iduser,addresse) VALUES(:iduser,:address)");
	$client->execute(array(
		'iduser' => $_SESSION['iduser'],
		'address' => $address
	    )
	);
	$_SESSION['isClient']=true;
}

function getClient($bdd){
	$query = $bdd->prepare("SELECT * FROM client WHERE iduser=:iduser");
	try {
		$query->execute(array(
			'iduser'=>$_SESSION['iduser']
			)
		);
	} catch (PDOException $e) {
		die("Erreur dans la recuperation de vos donnees : ".$e->getMessage());
	}
	return $query;
}

function getUsers($bdd)
{
	$userQuery = $bdd->prepare("SELECT * FROM user");
	try {
		$userQuery->execute();
	} catch (PDOException $e) {
		echo "Erreur : ".$e->getMessage();
	}
	return $userQuery;
}


function validateCm($bdd)
{	
	$idC = getClient($bdd);
	$idCl = $idC->fetch();
	$_SESSION['idClient'] = $idCl['idClient'];
	$idC->closeCursor();
	$cmdQuery = $bdd->prepare("INSERT INTO commande(idClient) VALUES (:idClient)");
	try {
		$cmdQuery->execute(array(
			'idClient'=>$_SESSION['idClient']
			)
		);
	} catch (PDOException $e) {
		die("Erreur dans la validation de votre commande a: ".$e->getMessage());
	}
	$idQuery = ($bdd->query("SELECT idCommande FROM commande ORDER BY idCommande DESC"))->fetch() or die("Erreur dans la validation de votre commande b");
	$idCmd = $idQuery['idCommande'];
	foreach ($_SESSION['cart'] as $value) :
		$lcQuery = $bdd->prepare("INSERT INTO lignecommande(idCommande, idProduit, quantite) VALUES (:idCmd, :idProd, :qte)");
		try {
			$lcQuery->execute(array(
					'idCmd'=>$idCmd,
					'idProd'=>$value->idproduit,
					'qte'=>$value->quantite
				)
			);
		} catch (PDOException $e) {
			die("Erreur dans la validation de votre commande c: ".$e->getMessage());
		}
	endforeach;
	return true;
}

function addToCart($idProduit, $qte)
{
	$toAdd = array(
		'idproduit'=> $idProduit,
		'quantite' => $qte,	
	);
	if (!isset($_COOKIE['cart#'.$_SESSION['iduser']])) :
		$_SESSION['cart'] = array(
			$toAdd
		);
		setcookie('cart#'.$_SESSION['iduser'],json_encode($_SESSION['cart']),time()+(3600*24*365));
		setcookie('#cart'.$_SESSION['iduser'],1,time()+(3600*24*365));
	else :
		$_SESSION['cart'] = json_decode($_COOKIE['cart#'.$_SESSION['iduser']]);
		$bi=false;
		foreach ($_SESSION['cart'] as $value) :
			if (is_object($value)):
				if ($value->idproduit==$toAdd['idproduit']) :
				$value->quantite+=$toAdd['quantite'];
				$bi = true;
				endif;
			endif;
		endforeach;
		if (!$bi) :
			array_push($_SESSION['cart'], $toAdd);
			$num = $_COOKIE['#cart'.$_SESSION['iduser']];
			$num+=1;
			setcookie('#cart'.$_SESSION['iduser'],false,time()+(3600*24*365));
			setcookie('#cart'.$_SESSION['iduser'],$num,time()+(3600*24*365));
		endif;
		setcookie('cart#'.$_SESSION['iduser'],false);
		setcookie('cart#'.$_SESSION['iduser'],json_encode($_SESSION['cart']),time()+(3600*24*365));
		
	endif;
}

?>