<?php 
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
   	die('Erreur : ' . $e->getMessage());
}

?>