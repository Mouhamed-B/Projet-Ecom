<?php
/*
  PHP version 7.4.1
  MySQL version 8.0.18
  La Mise en forme s'effectuera avec Bootstrap (dependant de JQuery et Popper.js)
*/
$host="localhost";
$user="root";
$password="lmbdrootsql"; // configuré comme tel dans le serveur
$dbname="shopsn_db";
try
{
	   $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
	   $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
   	die('Erreur lors de la connexion : ' . $e->getMessage());
}

?>