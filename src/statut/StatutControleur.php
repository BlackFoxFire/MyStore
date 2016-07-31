<?php

	/*
	*
	* StatutControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur des actions liées aux statuts d'articles
	*
	*/
	
	/* Définition de la classe. */
	class StatutControleur extends Controleur {
		
		// Manager des statuts d'article
		private $statutManager;
		
		// Constructeur de classe
		public function __construct() {
			$this->statutManager = new StatutManager();
		}
		
		// Action par defaut
		// Affiche la liste des statuts
		public function indexAction() {
			$statuts = $this->statutManager->getListe();
			
			if(count($statuts) == 0) {
				$aucunEnregistrement = true;
			}
			else {
				$aucunEnregistrement = false;
			}
			
			$this->render(array('aucunEnregistrement' => $aucunEnregistrement, 'statuts' => $statuts));
		}
		
		// Ajouter un statut d'article
		public function ajouterAction() {
			$donnees['statutSauve'] = false;
			$donnees['statut'] = "";
			
			if(isset($_POST['submit'])) {
				$statut = new Statut;
				
				if(!$statut->setStatut($_POST['statut'])) {
					$donnees['erreur'] = true;
				}
				$donnees['statut'] = $_POST['statut'];
				
				if($statut->estValide()) {
					$this->statutManager->save($statut);
					$donnees['statutSauve'] = true;
				}
			}
			
			$this->render($donnees);
		}
		
		// Modifie un statut d'article
		public function modifierAction() {
			$idStatut = $this->requete->getParametre("id");
			
			if(!is_numeric($idStatut) || $idStatut == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idStatut = (int) $idStatut;
			
			if(!$this->statutManager->existe($idStatut)) {
				throw new Exception("Le statut d'article n°$idStatut n'existe pas.");
			}
			
			$statut = $this->statutManager->read($idStatut);
			
			$donnees = array('statutModifie' => false, 'erreur' => false, 'idStatut' => $statut->getIdStatut(), 'nomStatut' => $statut->getStatut());
			
			if(isset($_POST['submit'])) {
				$nomStatut = $_POST['nomStatut'];
				$donnees['nomStatut'] = $nomStatut;
				
				if(!$statut->setStatut($nomStatut)) {
					$donnees['erreur'] = true;
				}
				
				if($statut->estValide() && !$donnees['erreur']) {
					$this->statutManager->save($statut);
					$donnees['statutModifie'] = true;
				}
				
			}
			
			$this->render($donnees);
		}
		
		// Supprime un statut d'article
		public function supprimerAction() {
			$idStatut = $this->requete->getParametre("id");
			
			if(!is_numeric($idStatut) || $idStatut == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idStatut = (int) $idStatut;
			
			if(!$this->statutManager->existe($idStatut)) {
				throw new Exception("Le statut d'article n°$idStatut n'existe pas.");
			}
			
			if($this->statutManager->delete($idStatut)) {
				$this->render();
			}
		}
		
	}
	/* Fin de la définition de la classe. */
