<?php

	/*
	*
	* Taille.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant une taille d'article
	*
	*/
	
	/* Définition de la classe. */
	class Taille {
		
		// Identifiant unique du taille
		private $idTaille;
		
		// Nom du taille
		private $taille;
	
		// Constructeur de classe
		public function __construct(array $donnees = null) {
			if(!is_null($donnees)) {
				$this->hydratation($donnees);
			}
		}
		
		// Initialise un objet taille
		private function hydratation(array $donnees) {
			foreach($donnees as $key => $valeur) {
				$methode = "set" . ucfirst($key);
				
				if(method_exists($this, $methode)) {
					$this->$methode($valeur);
				}
			}
		}
		
		// Retourne l'identifiant
		public function getIdTaille() {
			return $this->idTaille;
		}
		
		// Modifie l'identifiant
		private function setIdTaille($id) {
			if(is_numeric($id) && $id != 0) {
				$this->idTaille = (int) $id;
				
				return $this->idTaille;
			}
			
			return false;
		}
		
		// Retourne le taille
		public function getTaille() {
			return $this->taille;
		}
		
		// Modifie le taille
		public function setTaille($taille) {
			if(is_string($taille) && !empty($taille)) {
				$this->taille = (string) $taille;
				
				return $this->taille;
			}
			
			return false;
		}
		
		// Affiche l'objet taille
		public function __toString() {
			return $this->taille;
		}
		
		// Retourne true si c'est un nouveau taille
		public function estNouveau() {
			return is_null($this->idTaille);
		}
		
		// Retourne true si le taille est valide
		public function estValide() {
			return !empty($this->taille);
		}
		
	}
	/* Fin de la définition de la classe. */
