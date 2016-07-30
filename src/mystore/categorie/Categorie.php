<?php

	/*
	*
	* Categorie.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant une catégorie
	*
	*/
	
	/* Définition de la classe. */
	class Categorie {
		
		// Identifiant unique de la catégorie
		private $idCategorie;
		
		// Nom de la catégorie
		private $categorie;
		
		// Constructeur de classe
		public function __construct(array $donnees = null) {
			if(!is_null($donnees)) {
				$this->hydratation($donnees);
			}
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
		
		// Retourne l'identifiant
		public function getIdCategorie() {
			return $this->idCategorie;
		}
		
		// Modifie l'identifiant
		private function setIdCategorie($id) {
			if(is_numeric($id) && $id != 0) {
				$this->idCategorie = (int) $id;
				
				return $this->idCategorie;
			}
			
			return false;
		}
		
		// Retourne le nom de la catégorie
		public function getCategorie() {
			return $this->categorie;
		}
		
		// Modifie la catégorie
		public function setCategorie($categorie) {
			if(is_string($categorie) && !empty($categorie)) {
				$this->categorie = (string) $categorie;
				
				return $this->categorie;
			}
			
			return false;
		}
		
		// Affiche l'objet categorie
		public function __toString() {
			return $this->categorie;
		}
		
		// Retourne true si c'est une nouvelle catégorie
		public function estNouveau() {
			return is_null($this->idCategorie);
		}
		
		// Retourne true si la catégorie est valide
		public function estvalide() {
			return !empty($this->categorie);
		}
		
	}
	/* Fin de la définition de la classe. */
