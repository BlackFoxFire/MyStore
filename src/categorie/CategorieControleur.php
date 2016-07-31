<?php

	/*
	*
	* CategorieControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur des actions liées aux catégories d'articles
	*
	*/
	
	/* Définition de la classe. */
	class CategorieControleur extends Controleur {
		
		// Manager des catégories d'article
		private $categorieManager;
		
		// Constructeur de classe
		public function __construct() {
			$this->categorieManager = new CategorieManager();
		}
		
		// Action par defaut
		// Affiche la liste des catégories
		public function indexAction() {
			$categories = $this->categorieManager->getListe();
			
			if(count($categories) == 0) {
				$aucunEnregistrement = true;
			}
			else {
				$aucunEnregistrement = false;
			}
			
			$this->render(array('aucunEnregistrement' => $aucunEnregistrement, 'categories' => $categories));
		}
		
		// Ajouter une catégorie d'article
		public function ajouterAction() {
			$donnees['categorieSauvee'] = false;
			$donnees['categorie'] = "";
			
			if(isset($_POST['submit'])) {
				$categorie = new Categorie;
				
				if(!$categorie->setCategorie($_POST['categorie'])) {
					$donnees['erreur'] = true;
				}
				$donnees['categorie'] = $_POST['categorie'];
				
				if($categorie->estValide()) {
					$this->categorieManager->save($categorie);
					$donnees['categorieSauvee'] = true;
				}
			}
			
			$this->render($donnees);
		}
		
		// Modifie une catégorie d'article
		public function modifierAction() {
			$idCategorie = $this->requete->getParametre("id");
			
			if(!is_numeric($idCategorie) || $idCategorie == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idCategorie = (int) $idCategorie;
			
			if(!$this->categorieManager->existe($idCategorie)) {
				throw new Exception("Lcatégorie d'article n°$idCategorie n'existe pas.");
			}
			
			$categorie = $this->categorieManager->read($idCategorie);
			
			$donnees = array('categorieModifiee' => false, 'erreur' => false, 'idCategorie' => $categorie->getIdCategorie(), 'nomCategorie' => $categorie->getCategorie());
			
			if(isset($_POST['submit'])) {
				$nomCategorie = $_POST['nomCategorie'];
				$donnees['nomCategorie'] = $nomCategorie;
				
				if(!$categorie->setCategorie($nomCategorie)) {
					$donnees['erreur'] = true;
				}
				
				if($categorie->estValide() && !$donnees['erreur']) {
					$this->categorieManager->save($categorie);
					$donnees['categorieModifiee'] = true;
				}
				
			}
			
			$this->render($donnees);
		}
		
		// Supprime une catégorie d'article
		public function supprimerAction() {
			$idCategorie = $this->requete->getParametre("id");
			
			if(!is_numeric($idCategorie) || $idCategorie == 0) {
				throw new Exception("Identifiant non valide !");
			}
			
			$idCategorie = (int) $idCategorie;
			
			if(!$this->categorieManager->existe($idCategorie)) {
				throw new Exception("La catégorie d'article n°$idCategorie n'existe pas.");
			}
			
			if($this->categorieManager->delete($idCategorie)) {
				$this->render();
			}
		}
		
	}
	/* Fin de la définition de la classe. */
