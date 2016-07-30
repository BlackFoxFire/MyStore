<div class="enteteSection">
	Rechercher des articles :
</div>
<div class="contenuSection">
	<form method="post" action="Article/rechercherArticle">
		<div class="zoneDeRecherche">
			
			<select name="idType" id="idType">
				<option value="" selected>Types ...</option>
				<?php foreach($types as $cle => $donnees) { ?>
				<option value="<?= $cle ?>"><?= $donnees ?></option>
				<?php } ?>
			</select>
			
			<select name="idCategorie" id="idCategorie">
				<option value="" selected>Catégorie ...</option>
				<?php foreach($categories as $cle => $donnees) { ?>
				<option value="<?= $cle ?>"><?= $donnees ?></option>
				<?php } ?>
			</select>
			
			<select name="idTaille" id="idTaille">
				<option value="" selected>Taille ...</option>
				<?php foreach($tailles as $cle => $donnees) { ?>
				<option value="<?= $cle ?>"><?= $donnees ?></option>
				<?php } ?>
			</select>
			
			<select name="idCouleur" id="idCouleur">
				<option value="" selected>Couleur ...</option>
				<?php foreach($couleurs as $cle => $donnees) { ?>
				<option value="<?= $cle ?>"><?= $donnees ?></option>
				<?php } ?>
			</select>
			
			<select name="idStatut" id="idStatut">
				<option value="" selected>Statut ...</option>
				<?php foreach($statuts as $cle => $donnees) { ?>
				<option value="<?= $cle ?>"><?= $donnees ?></option>
				<?php } ?>
			</select>
			
			<input type="text" name="chaineDeRecherche" id="chaineDeRecherche" value="" />
			
			<input type="submit" name="submit" id="submit" value="Go" class="" />
		</div>
	</form>
</div>

<div class="contenuSection pageUpPageDown">
	<?php if($page > 1) { ?>
	<a href="Article/index/<?= $page - 1 ?>" class="bouton">Page précédante</a>
	<?php } else { ?>
	<div class="bouton">Page précédante</div>
	<?php } ?>
	<?php
		if($pageMax > 1) {
			$depart = 1;
			
			if($page - 4 > 1) $depart = $page - 4;
			$fin = $depart + 8;
			
			if($fin > $pageMax) {
				$fin = $pageMax;
				$depart = $fin - 8;
				if($depart < 1) $depart = 1;
			}
			
			echo "<div class=\"bouton\">Page : ";
			for($i=$depart; $i<=$fin; $i++) {
				if($i != $page)
					echo "<a href=\"Article/index/$i\">$i</a> ";
				else
					echo "$i ";
			}
			echo "</div>";
		}
	?>
	<?php if($page < $pageMax) { ?>
	<a href="Article/index/<?= $page + 1 ?>" class="bouton">Page suivante</a>
	<?php } else { ?>
	<div class="bouton">Page suivante</div>
	<?php } ?>
</div>
	
<div class="enteteSection">
	Liste des articles :
</div>
<div class="contenuSection">
	
	<?php foreach($articles as $donnees) { ?>
	
	<table class="listeArticles">
		<tr>
			<td colspan="2">
				<div class="labelListeArticle">Article n°<?= $donnees['idArticle'] ?> - <?= $donnees['article'] ?></div>
			</td>
		</tr>
		<tr>
			<td class="coloneImageArticle">
				<a href="Article/modifierArticle/<?= $donnees['idArticle'] ?>">
					<img src="<?= $donnees['imageArticle'] ?>" alt="<?= $donnees['article'] ?>" class="imageArticle" />
				</a>
			</td>
			<td class="coloneDetailArticle">
				
				<div class="detailListeArticle">Types : <?= $types[$donnees['idType']] ?></div>
				<div class="detailListeArticle">Catégorie : <?= $categories[$donnees['idCategorie']] ?></div>
				<div class="detailListeArticle">Taille : <?= $tailles[$donnees['idTaille']] ?></div>
				<div class="detailListeArticle">Couleur : <?= $couleurs[$donnees['idCouleur']] ?></div>
				<div class="detailListeArticle">Statut : <?= $statuts[$donnees['idStatut']] ?></div>
				<div class="detailListeArticle">Prix : <?= $donnees['prix'] ?> €</div>
				
				<textarea class="zoneTexte" readonly><?= $donnees['descriptionArticle'] ?></textarea>
				
			</td>
		</tr>
	</table>
	
	<?php } ?>
	
</div>

<div class="contenuSection pageUpPageDown">
	<?php if($page > 1) { ?>
	<a href="Article/index/<?= $page - 1 ?>" class="bouton">Page précédante</a>
	<?php } else { ?>
	<div class="bouton">Page précédante</div>
	<?php } ?>
	<?php
		if($pageMax > 1) {
			$depart = 1;
			
			if($page - 4 > 1) $depart = $page - 4;
			$fin = $depart + 8;
			
			if($fin > $pageMax) {
				$fin = $pageMax;
				$depart = $fin - 8;
				if($depart < 1) $depart = 1;
			}
			
			echo "<div class=\"bouton\">Page : ";
			for($i=$depart; $i<=$fin; $i++) {
				if($i != $page)
					echo "<a href=\"Article/index/$i\">$i</a> ";
				else
					echo "$i ";
			}
			echo "</div>";
		}
	?>
	<?php if($page < $pageMax) { ?>
	<a href="Article/index/<?= $page + 1 ?>" class="bouton">Page suivante</a>
	<?php } else { ?>
	<div class="bouton">Page suivante</div>
	<?php } ?>
</div>
