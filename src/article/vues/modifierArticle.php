<div class="enteteSection">
	Modifier un article : 
</div>
<div class="contenuSection">
	<form method="post" action="Article/modifierArticle/<?= $article['idArticle'] ?>" enctype="multipart/form-data">
		
		<table class="article">
			<tr>
				<td colspan="2">
					<div class="labelListeArticle">
						<label for="nomArticle">Article n°<?= $article['idArticle'] ?> - Nom de l'article : </label>
						<input type="text" name="nomArticle" id="nomArticle" value="<?= $article['article'] ?>" size="30" maxlength="30"/>
					</div>
				</td>
			</tr>
			<tr>
				<td class="coloneImageArticle">
					<a href="<?= $article['imageArticle'] ?>"><img src="<?= $article['imageArticle'] ?>" alt="<?= $article['article'] ?>" class="imageArticle" /></a>
				</td>
				<td class="coloneDetailArticle">
					<div class="detailListeArticle">
						<label for="idType" class="labelDesDetails">Type : </label>
						<select name="idType" id="idType">
						<?php foreach($types as $cle => $donnees) { 
							if($article['idType'] == $cle) {
						?>
							<option value="<?= $cle ?>" selected><?= $donnees ?></option>
						<?php } else { ?>
							<option value="<?= $cle ?>"><?= $donnees ?></option>
						<?php } } ?>
						</select>
					</div>
					<div class="detailListeArticle">
						<label for="idCategorie" class="labelDesDetails">Catégorie : </label>
						<select name="idCategorie" id="idCategorie">
						<?php foreach($categories as $cle => $donnees) { 
							if($article['idCategorie'] == $cle) {
						?>
							<option value="<?= $cle ?>" selected><?= $donnees ?></option>
						<?php } else { ?>
							<option value="<?= $cle ?>"><?= $donnees ?></option>
						<?php } } ?>
						</select>
					</div>
					<div class="detailListeArticle">
						<label for="idTaille" class="labelDesDetails">Taille : </label>
						<select name="idTaille" id="idTaille">
						<?php foreach($tailles as $cle => $donnees) { 
							if($article['idTaille'] == $cle) {
						?>
							<option value="<?= $cle ?>" selected><?= $donnees ?></option>
						<?php } else { ?>
							<option value="<?= $cle ?>"><?= $donnees ?></option>
						<?php } } ?>
						</select>
					</div>
					<div class="detailListeArticle">
						<label for="idCouleur" class="labelDesDetails">Couleur : </label>
						<select name="idCouleur" id="idCouleur">
						<?php foreach($couleurs as $cle => $donnees) { 
							if($article['idCouleur'] == $cle) {
						?>
							<option value="<?= $cle ?>" selected><?= $donnees ?></option>
						<?php } else { ?>
							<option value="<?= $cle ?>"><?= $donnees ?></option>
						<?php } } ?>
						</select>
					</div>
					<div class="detailListeArticle">
						<label for="idStatut" class="labelDesDetails">Statut : </label>
						<select name="idStatut" id="idStatut">
						<?php foreach($statuts as $cle => $donnees) { 
							if($article['idStatut'] == $cle) {
						?>
							<option value="<?= $cle ?>" selected><?= $donnees ?></option>
						<?php } else { ?>
							<option value="<?= $cle ?>"><?= $donnees ?></option>
						<?php } } ?>
						</select>
					</div>
					
					<div class="detailListeArticle">
						<label for="prix" class="labelDesDetails">Prix : </label>
						<input type="text" name="prix" id="prix" value="<?= $article['prix'] ?>" size="30" maxlength="6"/>
					</div>
					
					<div class="detailListeArticle">
						<label for="lienEbay" class="labelDesDetails">lien Ebay : </label>
						<input type="url" name="lienEbay" id="lienEbay" value="<?= $article['lienEbay'] ?>" size="30" maxlength="255" />
					</div>
					
					<div class="detailListeArticle">
						<label for="imageArticle" class="labelDesDetails">Image : </label>
						<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
						<input type="file" name="imageArticle" id="imageArticle" />
					</div>
					
					<div class="detailListeArticle description">
						<label for="descriptionArticle" class="labelDesDetails">Description : </label>
						<br />
						<textarea name="descriptionArticle" id="descriptionArticle" class="zoneTexte fondBlanc"><?= $article['descriptionArticle'] ?></textarea>
					</div>
					
					<p>
						<input type="submit" name="submit" id="submit" value="Enregister les modifications" />
						<!--<input type="submit" name="supprimerArticle" id="supprimerArticle" value="Supprimer l'article" />-->
						<a href="Article/supprimer/<?= $article['idArticle'] ?>" class="bouton">Supprimer l'article</a>
					</p>
				</td>
			</tr>
		</table>
		
	</form>
</div>