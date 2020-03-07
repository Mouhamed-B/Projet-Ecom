<?php 
session_start();
$libellecat=(isset($_GET['libelle']))?$_GET['libelle']:null;
$formValidity = true;
$listValidity = true;
$title = "LePapyrus - Nos Categories";
require 'database/queries.php';
require 'header.php';
?>
<div class="col-9 mt-5">
	<div class="row">
		<?php $response = getProduct($bdd,null,$libellecat);
		while ($list=$response->fetch()) :?>
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
		$response->closeCursor(); ?>
	</div>
</div>
</div>
</div>
<?php require 'footer.php';?>