<?php

	/*
	*
	* Statut.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant un statut d'article
	*
	*/
	
	/* Définition de la classe. */
	class Statut {
		
		// Identifiant unique du statut
		private $idStatut;
		
		// Nom du statut
		private $statut;
	
		// Constructeur de classe
		public function __construct(array $donnees = null) {
			if(!is_null($donnees)) {
				$this->hydratation($donnees);
			}
		}
		
		// Initialise un objet statut
		private function hydratation(array $donnees) {
			foreach($donnees as $key => $valeur) {
				$methode = "set" . ucfirst($key);
				
				if(method_exists($this, $methode)) {
					$this->$methode($valeur);
				}
			}
		}
		
		// Retourne l'identifiant
		public function getIdStatut() {
			return $this->idStatut;
		}
		
		// Modifie l'identifiant
		private function setIdStatut($id) {
			if(is_numeric($id) && $id != 0) {
				$this->idStatut = (int) $id;
				
				return $this->idStatut;
			}
			
			return false;
		}
		
		// Retourne le statut
		public function getStatut() {
			return $this->statut;
		}
		
		// Modifie le statut
		public function setStatut($statut) {
			if(is_string($statut) && !empty($statut)) {
				$this->statut = (string) $statut;
				
				return $this->statut;
			}
			
			return false;
		}
		
		// Affiche l'objet statut
		public function __toString() {
			return $this->statut;
		}
		
		// Retourne true si c'est un nouveau statut
		public function estNouveau() {
			return is_null($this->idStatut);
		}
		
		// Retourne true si le statut est valide
		public function estValide() {
			return !empty($this->statut);
		}
		
	}
	/* Fin de la définition de la classe. */
