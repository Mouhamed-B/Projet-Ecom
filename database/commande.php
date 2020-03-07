<?php 
session_start();
//ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
if (isset($_POST['cmd'])):
	require 'queries.php';
	if(!$_SESSION['isClient']):
		$address = $_POST['address1'].'|'.$_POST['adress2'];
		addClient($bdd, $address);
	endif;
	$valid = validateCm($bdd);
	if($valid):
		unset($_SESSION['cart']);
		setcookie('cart#'.$_SESSION['iduser'],null,-1);
		setcookie('#cart'.$_SESSION['iduser'],null,-1);
	endif;
endif;
echo "<script type='text/javascript'> document.location = './../Checkout.php?validation=$valid'; </script>";
?>