<?php

	/*
	*
	* TypeControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur des actions liées aux types d'articles
	*
	*/
	
	/* Définition de la classe. */
	class TypeControleur extends Controleur {
		
		// Manager des types d'article
		private $typeManager;
		
		// Constructeur de classe
		public function __construct() {
			$this->typeManager = new TypeManager();
		}
		
		// Action par defaut
		// Affiche la liste des types
		public function indexAction() {
			$types = $this->typeManager->getListe();
			
			if(count($types) == 0) {
				$aucunEnregistrement = true;
			}
			else {
				$aucunEnregistrement = false;
			}
			
			$this->render(array('aucunEnregistrement' => $aucunEnregistrement, 'types' => $types));
		}
		
		// Ajouter un type d'article
		public function ajouterAction() {
			$donnees['typeSauve'] = false;
			$donnees['type']= "";
			
			if(isset($_POST['submit'])) {
				$type = new Type;
				
				if(!$type->setType($_POST['type'])) {
					$donnees['erreur'] = true;
				}
				$donnees['type'] = $_POST['type'];
				
				if($type->estValide()) {
					$this->typeManager->save($type);
					$donnees['typeSauve'] = true;
				}
			}
			
			$this->render($donnees);
		}
		
		// Modifie un type d'article
		public function modifierAction() {
			$idType = $this->requete->getParametre("id");
			
			if(!is_numeric($idType) || $idType == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idType = (int) $idType;
			
			if(!$this->typeManager->existe($idType)) {
				throw new Exception("Le type d'article n°$idType n'existe pas.");
			}
			
			$type = $this->typeManager->read($idType);
			
			$donnees = array('typeModifie' => false, 'erreur' => false, 'idType' => $type->getIdType(), 'nomType' => $type->getType());
			
			if(isset($_POST['submit'])) {
				$nomType = $_POST['nomType'];
				$donnees['nomType'] = $nomType;
				
				if(!$type->setType($nomType)) {
					$donnees['erreur'] = true;
				}
				
				if($type->estValide() && !$donnees['erreur']) {
					$this->typeManager->save($type);
					$donnees['typeModifie'] = true;
				}
				
			}
			
			$this->render($donnees);
		}
		
		// Supprime un type d'article
		public function supprimerAction() {
			$idType = $this->requete->getParametre("id");
			
			if(!is_numeric($idType) || $idType == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idType = (int) $idType;
			
			if(!$this->typeManager->existe($idType)) {
				throw new Exception("Le type d'article n°$idType n'existe pas.");
			}
			
			if($this->typeManager->delete($idType)) {
				$this->render();
			}
		}
		
	}
	/* Fin de la définition de la classe. */
