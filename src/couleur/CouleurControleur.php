<?php

	/*
	*
	* CouleurControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur des actions liées aux couleurs d'articles
	*
	*/
	
	/* Définition de la classe. */
	class CouleurControleur extends Controleur {
		
		// Manager des couleurs d'article
		private $couleurManager;
		
		// Constructeur de classe
		public function __construct() {
			$this->couleurManager = new CouleurManager();
		}
		
		// Action par defaut
		// Affiche la liste des couleurs
		public function indexAction() {
			$couleurs = $this->couleurManager->getListe();
			
			if(count($couleurs) == 0) {
				$aucunEnregistrement = true;
			}
			else {
				$aucunEnregistrement = false;
			}
			
			$this->render(array('aucunEnregistrement' => $aucunEnregistrement, 'couleurs' => $couleurs));
		}
		
		// Ajouter une couleur d'article
		public function ajouterAction() {
			$donnees['couleurSauvee'] = false;
			$donnees['couleur'] = "";
			
			if(isset($_POST['submit'])) {
				$couleur = new Couleur;
				
				if(!$couleur->setCouleur($_POST['couleur'])) {
					$donnees['erreur'] = true;
				}
				$donnees['couleur'] = $_POST['couleur'];
				
				if($couleur->estValide()) {
					$this->couleurManager->save($couleur);
					$donnees['couleurSauvee'] = true;
				}
			}
			
			$this->render($donnees);
		}
		
		// Modifie une couleur d'article
		public function modifierAction() {
			$idCouleur = $this->requete->getParametre("id");
			
			if(!is_numeric($idCouleur) || $idCouleur == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idCouleur = (int) $idCouleur;
			
			if(!$this->couleurManager->existe($idCouleur)) {
				throw new Exception("La couleur d'article n°$idCouleur n'existe pas.");
			}
			
			$couleur = $this->couleurManager->read($idCouleur);
			
			$donnees = array('couleurModifiee' => false, 'erreur' => false, 'idCouleur' => $couleur->getIdCouleur(), 'nomCouleur' => $couleur->getCouleur());
			
			if(isset($_POST['submit'])) {
				$nomCouleur = $_POST['nomCouleur'];
				$donnees['nomCouleur'] = $nomCouleur;
				
				if(!$couleur->setCouleur($nomCouleur)) {
					$donnees['erreur'] = true;
				}
				
				if($couleur->estValide() && !$donnees['erreur']) {
					$this->couleurManager->save($couleur);
					$donnees['couleurModifiee'] = true;
				}
				
			}
			
			$this->render($donnees);
		}
		
		// Supprime une couleur d'article
		public function supprimerAction() {
			$idCouleur = $this->requete->getParametre("id");
			
			if(!is_numeric($idCouleur) || $idCouleur == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idCouleur = (int) $idCouleur;
			
			if(!$this->couleurManager->existe($idCouleur)) {
				throw new Exception("La couleur d'article n°$idCouleur n'existe pas.");
			}
			
			if($this->couleurManager->delete($idCouleur)) {
				$this->render();
			}
		}
		
	}
	/* Fin de la définition de la classe. */
