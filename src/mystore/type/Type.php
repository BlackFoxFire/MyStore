<?php

	/*
	*
	* Type.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant un type d'article
	*
	*/
	
	/* Définition de la classe. */
	class Type {
		
		// Identifiant unique du type
		private $idType;
		
		// Nom du type
		private $type;
	
		// Constructeur de classe
		public function __construct(array $donnees = null) {
			if(!is_null($donnees)) {
				$this->hydratation($donnees);
			}
		}
		
		// Initialise un objet type
		private function hydratation(array $donnees) {
			foreach($donnees as $key => $valeur) {
				$methode = "set" . ucfirst($key);
				
				if(method_exists($this, $methode)) {
					$this->$methode($valeur);
				}
			}
		}
		
		// Retourne l'identifiant
		public function getIdType() {
			return $this->idType;
		}
		
		// Modifie l'identifiant
		private function setIdType($id) {
			if(is_numeric($id) && $id != 0) {
				$this->idType = (int) $id;
				
				return $this->idType;
			}
			
			return false;
		}
		
		// Retourne le type
		public function getType() {
			return $this->type;
		}
		
		// Modifie le type
		public function setType($type) {
			if(is_string($type) && !empty($type)) {
				$this->type = (string) $type;
				
				return $this->type;
			}
			
			return false;
		}
		
		// Affiche l'objet type
		public function __toString() {
			return $this->type;
		}
		
		// Retourne true si c'est un nouveau type
		public function estNouveau() {
			return is_null($this->idType);
		}
		
		// Retourne true si le type est valide
		public function estValide() {
			return !empty($this->type);
		}
		
	}
	/* Fin de la définition de la classe. */
