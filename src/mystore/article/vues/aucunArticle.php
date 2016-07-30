<div class="enteteSection">
	Rechercher des articles :
</div>
<div class="contenuSection">
	<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>/Article/rechercherArticle">
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

<div class="enteteSection">
	Liste des articles :
</div>
<div class="contenuSection">
	<br />
	<p class="message">Aucun article trouvé.</p>
	<br />
</div>