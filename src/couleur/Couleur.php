<?php

	/*
	*
	* Couleur.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant une couleur d'article
	*
	*/
	
	/* Définition de la classe. */
	class Couleur {
		
		// Identifiant unique du couleur
		private $idCouleur;
		
		// Nom du couleur
		private $couleur;
	
		// Constructeur de classe
		public function __construct(array $donnees = null) {
			if(!is_null($donnees)) {
				$this->hydratation($donnees);
			}
		}
		
		// Initialise un objet couleur
		private function hydratation(array $donnees) {
			foreach($donnees as $key => $valeur) {
				$methode = "set" . ucfirst($key);
				
				if(method_exists($this, $methode)) {
					$this->$methode($valeur);
				}
			}
		}
		
		// Retourne l'identifiant
		public function getIdCouleur() {
			return $this->idCouleur;
		}
		
		// Modifie l'identifiant
		private function setIdCouleur($id) {
			if(is_numeric($id) && $id != 0) {
				$this->idCouleur = (int) $id;
				
				return $this->idCouleur;
			}
			
			return false;
		}
		
		// Retourne le couleur
		public function getCouleur() {
			return $this->couleur;
		}
		
		// Modifie le couleur
		public function setCouleur($couleur) {
			if(is_string($couleur) && !empty($couleur)) {
				$this->couleur = (string) $couleur;
				
				return $this->couleur;
			}
			
			return false;
		}
		
		// Affiche l'objet couleur
		public function __toString() {
			return $this->couleur;
		}
		
		// Retourne true si c'est un nouveau couleur
		public function estNouveau() {
			return is_null($this->idCouleur);
		}
		
		// Retourne true si le couleur est valide
		public function estValide() {
			return !empty($this->couleur);
		}
		
	}
	/* Fin de la définition de la classe. */
