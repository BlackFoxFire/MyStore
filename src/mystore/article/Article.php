<?php

	/*
	*
	* Article.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant d'article
	*
	*/
	
	/* Définition de la classe. */
	class Article {
		
		// Identifiant de l'article
		private $idArticle;
		// Nom de l'article
		private $article;
		// Chemin vers l'image de l'article
		private $imageArticle;
		// Description de l'article
		private $descriptionArticle;
		// Prix de l'article
		private $prix;
		// Lien vers la page ebay de l'article
		private $lienEbay;
		// Identifiant du statut de l'article
		private $idStatut;
		// Identifiant du type d'article
		private $idType;
		// Identifiant de la catégorie de l'article
		private $idCategorie;
		// Identifiant de la taille de l'article
		private $idTaille;
		// Identifiant de la couleur de l'article
		private $idCouleur;
		
		// Constructeur de classe
		public function __construct(array $donnees = null) {
			if(!is_null($donnees)) {
				$this->hydratation($donnees);
			}
		}
		
		// Retourne l'identifiant de l'article
		public function getIdArticle() {
			return $this->idArticle;
		}
		
		// Retourne le nom de l'article
		public function getArticle() {
			return $this->article;
		}
		
		// Modifie le nom de l'article
		public function setArticle($article) {
			if(is_string($article) && !empty($article)) {
				$this->article = (string) $article;
				
				return $this->article;
			}
			
			return false;
		}
		
		// Retourne de chemin vers l'image de l'article
		public function getImageArticle() {
			return $this->imageArticle;
		}
		
		// Modifie le chemin vers l'image de l'article
		public function setImageArticle($image) {
			if(is_string($image) && !empty($image)) {
				$this->imageArticle = (string) $image;
				
				return $this->imageArticle;
			}
			
			return false;
		}
		
		// Retourne la description de l'article
		public function getDescriptionArticle() {
			return $this->descriptionArticle;
		}
		
		// Modifie la description de l'article
		public function setDescriptionArticle($description) {
			if(is_string($description)) {
				$this->descriptionArticle = (string) $description;
				
				return $this->descriptionArticle;
			}
			
			return false;
		}
		
		// Retourne le prix de l'article
		public function getPrix() {
			return $this->prix;
		}
		
		// Modifie le prix de l'article
		public function setPrix($prix) {
			if(is_numeric($prix) && $prix > 0) {
				$this->prix = (float) $prix;
				
				return $this->prix;
			}
			
			return false;
		}
		
		// Retourne le lien ebay de l'article
		public function getLienEbay() {
			return $this->lienEbay;
		}
		
		// Modifie le lien ebay de l'article
		public function setLienEbay($lien) {
			if(is_string($lien)) {
				$this->lienEbay = (string) $lien;
				
				return $this->lienEbay = $lien;
			}
			return false;
		}
		
		// Retourne l'identifiant du statut de l'article
		public function getIdStatut() {
			return $this->idStatut;
		}
		
		// Modifie l'identifiant du statut de l'article
		public function setIdStatut($id) {
			if(is_numeric($id) && $id > 0) {
				$this->idStatut = (int) $id;
				
				return $this->idStatut;
			}
			return false;
		}
		
		// Retourne l'identifiant du type de l'article
		public function getIdType() {
			return $this->idType;
		}
		
		// Modifie l'identifiant du type de l'article
		public function setIdType($id) {
			if(is_numeric($id) && $id > 0) {
				$this->idType = (int) $id;
				
				return $this->idType;
			}
			return false;
		}
		
		// Retourne l'identifiant de la catégorie de l'article
		public function getIdCategorie() {
			return $this->idCategorie;
		}
		
		// Modifie l'identifiant de la catégorie de l'article
		public function setIdCategorie($id) {
			if(is_numeric($id) && $id > 0) {
				$this->idCategorie = (int) $id;
				
				return $this->idCategorie;
			}
			return false;
		}
		
		// Retourne l'identifiant de la taille de l'articleé
		public function getIdTaille() {
			return $this->idTaille;
		}
		
		// Modifie l'identifiant de la taille de l'article
		public function setIdTaille($id) {
			if(is_numeric($id) && $id > 0) {
				$this->idTaille = (int) $id;
				
				return $this->idTaille;
			}
			return false;
		}
		
		// Retourne l'identifiant de la couleur de l'article
		public function getIdCouleur() {
			return $this->idCouleur;
		}
		
		// Modifie l'identifiant de la couleur de l'article
		public function setIdCouleur($id) {
			if(is_numeric($id) && $id > 0) {
				$this->idCouleur = (int) $id;
				
				return $this->idCouleur;
			}
			return false;
		}
		
		// Retourne l'objet sour forme de chaine de caratère
		public function __toString() {
			return $this->article;
		}
		
		// Retourne true si c'est un nouvel article
		public function estNouveau() {
			return is_null($this->idArticle);
		}
		
		// Retourne true si l'article est valide
		public function estValide() {
			// return !empty($this->article) && ;
		}
		
		// Initialise un objet
		private function hydratation(array $donnees) {
			foreach($donnees as $key => $valeur) {
				$methode = "set" . ucfirst($key);
				
				if(method_exists($this, $methode)) {
					$this->$methode($valeur);
				}
			}
		}
		
		// Modifie l'identifiant de l'article
		private function setIdArticle($id) {
			if(is_numeric($id) && $id > 0) {
				$this->idArticle = (int) $id;
				
				return $this->idArticle;
			}
			
			return false;
		}
		
	}
	/* Fin de la définition de la classe. */
