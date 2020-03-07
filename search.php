<?php
session_start();
if (isset($_GET['search'])):
	$keywords=$_GET['search'].' '.$_GET['category'];
	require 'database/connexion.php';
	$query = $bdd->prepare("
		SELECT * FROM category c INNER JOIN produit p ON p.idcat=c.idcat WHERE MATCH(p.libelle,p.caract) AGAINST (:keywords IN NATURAL LANGUAGE MODE) OR MATCH(c.libellecat) AGAINST (:keywords IN NATURAL LANGUAGE MODE)
		");
	try {
		$query->execute(array(
			'keywords' => $keywords
		));
	} catch (PDOException $e) {
		echo "erreur lors de la recherche : ".$e->getMessage();
	}
	$formValidity = true;
	$listValidity = true;
	$title = "LePapyrus - Recherche";
	require 'database/queries.php';
	require 'header.php';
	?>
	<div class="col-9 mt-5">
		<div class="row">
			<?php
			while ($list=$query->fetch()) :?>
				<div class="col-lg-3 col-md-3 col-sm-6 mb-4">
					<div class="card">
						<a href="item.php?id=<?=$list['idProduit']?>"><img class="card-img-top img-fluid" src="/images/<?=$list['img']?>" alt="<?=$list['libelle']?>"></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="item.php?id=<?=$list['idProduit']?>"><?=$list['libelle']?></a>
							</h4>
							<h5><?=$list['prix']?> FCFA</h5>
							<p class="card-text overflow"><?=$list['caract']?><hr><b><?=$list['libellecat']?></b></p>
						</div>
						<div class="card-footer">
							<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
						</div>
					</div>
				</div>
			<?php endwhile; 
			$query->closeCursor(); ?>
		</div>
	</div>
	</div>
	</div>
	<?php require 'footer.php';
else :
	header('Location:/');
endif;
?>