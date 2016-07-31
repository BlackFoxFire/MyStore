<?php

	/*
	*
	* TailleControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur des actions liées aux tailles d'articles
	*
	*/
	
	/* Définition de la classe. */
	class TailleControleur extends Controleur {
		
		// Manager des tailles d'article
		private $tailleManager;
		
		// Constructeur de classe
		public function __construct() {
			$this->tailleManager = new TailleManager();
		}
		
		// Action par defaut
		// Affiche la liste des tailles
		public function indexAction() {
			$tailles = $this->tailleManager->getListe();
			
			if(count($tailles) == 0) {
				$aucunEnregistrement = true;
			}
			else {
				$aucunEnregistrement = false;
			}
			
			$this->render(array('aucunEnregistrement' => $aucunEnregistrement, 'tailles' => $tailles));
		}
		
		// Ajouter une taille d'article
		public function ajouterAction() {
			$donnees['tailleSauvee'] = false;
			$donnees['taille'] = "";
			
			if(isset($_POST['submit'])) {
				$taille = new Taille;
				
				if(!$taille->setTaille($_POST['taille'])) {
					$donnees['erreur'] = true;
				}
				$donnees['taille'] = $_POST['taille'];
				
				if($taille->estValide()) {
					$this->tailleManager->save($taille);
					$donnees['tailleSauvee'] = true;
				}
			}
			
			$this->render($donnees);
		}
		
		// Modifie une taille d'article
		public function modifierAction() {
			$idTaille = $this->requete->getParametre("id");
			
			if(!is_numeric($idTaille) || $idTaille == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idTaille = (int) $idTaille;
			
			if(!$this->tailleManager->existe($idTaille)) {
				throw new Exception("La taille d'article n°$idTaille n'existe pas.");
			}
			
			$taille = $this->tailleManager->read($idTaille);
			
			$donnees = array('tailleModifiee' => false, 'erreur' => false, 'idTaille' => $taille->getIdTaille(), 'nomTaille' => $taille->getTaille());
			
			if(isset($_POST['submit'])) {
				$nomTaille = $_POST['nomTaille'];
				$donnees['nomTaille'] = $nomTaille;
				
				if(!$taille->setTaille($nomTaille)) {
					$donnees['erreur'] = true;
				}
				
				if($taille->estValide() && !$donnees['erreur']) {
					$this->tailleManager->save($taille);
					$donnees['tailleModifiee'] = true;
				}
				
			}
			
			$this->render($donnees);
		}
		
		// Supprime une taille d'article
		public function supprimerAction() {
			$idTaille = $this->requete->getParametre("id");
			
			if(!is_numeric($idTaille) || $idTaille == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idTaille = (int) $idTaille;
			
			if(!$this->tailleManager->existe($idTaille)) {
				throw new Exception("La taille d'article n°$idTaille n'existe pas.");
			}
			
			if($this->tailleManager->delete($idTaille)) {
				$this->render();
			}
		}
		
	}
	/* Fin de la définition de la classe. */
