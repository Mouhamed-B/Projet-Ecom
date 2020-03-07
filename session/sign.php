<?php
session_start();
if (isset($_POST['signin'])) :
	require '../database/queries.php';
	$_SESSION['check']= checkIds($bdd, $_POST['email'], $_POST['logpass']);
	a:
	header('Location:'.$_SERVER['HTTP_REFERER']);
elseif (isset($_POST['signout'])) :
	session_unset();
	goto a;
elseif (isset($_POST['signup'])) :
	createUser($bdd, $_POST['email'], $_POST['passwd'], $_POST['nom'], $_POST['pnom'], $_POST['sexe']);
	if (checkIds($bdd, $_POST['email'], $_POST['passwd'])):
		header('Location:/?check=true');
	endif;
elseif (isset($_SESSION['nom'])) :
	header("Location : /");
else :
	require '../database/queries.php';
	$title = "LePapyrus - Inscription";
	$formValidity = false;
	$listValidity = false;
	require '../header.php';
?>
<img src="/images/papyrus.png" class="img-fluid ml-auto mr-auto">
<div class="container mt-2">
	<h1 align="center" class="ml-auto mr-auto mt-2">Incription</h1><b><hr></b>
	<form class="ml-auto mr-auto" id="signup" method="post" action="">
		<div class="form-group">
			<label for="nom">Nom : </label>
			<input type="text" name="nom" class="form-control">
		</div>
		<div class="form-group">
			<label for="pnom">Prénom : </label>
			<input type="text" name="pnom" class="form-control">
		</div>
		<div class="form-group">
			<label for="email">E-mail : </label>
			<input type="email" name="email" class="form-control">
		</div>
		<div class="form-group">
			<label for="passwd">Choisissez un mot de passe : </label>
			<input type="password" id="passwd" name="passwd" class="form-control">
		</div>
		<div class="form-group">
			<input type="radio" name="sexe" value="M" >Masculin<br>
			<input type="radio" name="sexe" value="F">Féminin
		</div>
		<button type="submit" name="signup" class="btn btn-outline-primary">S'inscrire</button>
	</form>
</div>
<!-- div.container -->
</div>
<!-- div.row -->
</div>
<?php
require '../footer.php'; 
endif;
?>