<div class="enteteSection">
	Détails de l'article : 
</div>
<div class="contenuSection">
	<table class="article">
		<tr>
			<td colspan="2">
				<div class="labelListeArticle">
					<div class="labelListeArticle">Article n°<?= $article['idArticle'] ?> - <?= $article['article'] ?></div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="coloneImageArticle">
				<a href="<?= $article['imageArticle'] ?>"><img src="<?= $article['imageArticle'] ?>" alt="<?= $article['article'] ?>" class="imageArticle" /></a>
			</td>
			<td class="coloneDetailArticle">
				
				<div class="detailListeArticle">Types : <?= $types[$article['idType']] ?></div>
				<div class="detailListeArticle">Catégorie : <?= $categories[$article['idCategorie']] ?></div>
				<div class="detailListeArticle">Taille : <?= $tailles[$article['idTaille']] ?></div>
				<div class="detailListeArticle">Couleur : <?= $couleurs[$article['idCouleur']] ?></div>
				<div class="detailListeArticle">Statut : <?= $statuts[$article['idStatut']] ?></div>
				<div class="detailListeArticle">Prix : <?= $article['prix'] ?> €</div>
				
				<?php if(!empty($article['lienEbay'])) { ?>
				<div class="detailListeArticle">Ebay : <a href="<?= $article['lienEbay'] ?>"><?= substr($article['lienEbay'], 0, 30) . " ..." ?></a></div>
				<?php } ?>
				
				<div class="detailListeArticle description">
					<label for="descriptionArticle" class="labelDesDetails">Description : </label>
					<br />
					<textarea name="descriptionArticle" id="descriptionArticle" class="zoneTexte fondBlanc" readonly><?= $article['descriptionArticle'] ?></textarea>
				</div>
				
			</td>
		</tr>
	</table>
</div>