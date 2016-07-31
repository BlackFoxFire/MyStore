<?php

	/*
	*
	* tailleManager.php
	* @Auteur : Christophe Dufour
	*
	* Fournit les services d'accès à la base de données
	* pour les tailles d'articles
	*
	*/
	
	/* Définition de la classe. */
	class tailleManager extends Manager {
		
		// A EFFACER
		public function getListetailles() {
			$sql = 'select * from tailles order by taille asc';
			
			$resultat = $this->executerRequete($sql);
			
			foreach($resultat as $donnees) {
				$tailles[$donnees['idTaille']] = $donnees['taille'];
			}
			
			$resultat->closeCursor();
			
			return $tailles;
		}
		
		// Retourne une liste des tailles sous forme d'objet
		public function getListe($order = 0, $offset = 0, $limit = 0) {
			$sql = "select * from tailles";
			
			if(is_int($limit) && $limit != 0) {
				if(is_int($offset)) {
					$sql .= " limit " . (int) $offset . ", " . (int) $limit;
				}
			}
			
			if($order > 0)
				$sql .= " order by taille asc";
			
			if($order < 0)
				$sql .= " order by taille desc";
			
			$resultat = $this->executerRequete($sql);
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			foreach($resultat as $donnees) {
				$tailles[$donnees['idTaille']] = new Taille($donnees);
			}
			
			$resultat->closeCursor();
			
			return $tailles;
		}
		
		// Vérifie si un enregistrement existe
		public function existe($id) {
			$sql = "select idTaille from tailles where idTaille=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$nombre = $resultat->rowCount();
			
			$resultat->closeCursor();
			
			return $nombre;
		}
		
		// Permets de sauver une catégorie
		public function save(taille $taille) {
			if($taille->estValide()) {
				if($taille->estNouveau()) {
					$this->add($taille);
				}
				else {
					$this->update($taille);
				}
			}
		}
		
		// Lit un enregistrement précis
		public function read($id) {
			$sql = "select * from tailles where idTaille=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			if($resultat->rowCount() == 0)
				return false;
			
			$taille = new Taille($resultat->fetch());
			$resultat->closeCursor();
			
			return $taille;
		}
		
		// Supprime une catégorie
		public function delete($id) {
			$sql = "delete from tailles where idTaille=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			
			return $resultat;
		}
		
		// Ajoute une catégorie dans la base de données
		protected function add(Taille $taille) {
			$sql = "insert into tailles(taille) values(?)";
			
			$resultat = $this->executerRequete($sql, array($taille->getTaille()));
			
			return $resultat;
		}
		
		// Mets à jour une catégorie de la base de données
		protected function update(Taille $taille) {
			$sql = "update tailles set taille=? where idTaille=?";
			
			$resultat = $this->executerRequete($sql, array($taille->getTaille(), $taille->getIdTaille()));
			
			return $resultat;
		}
		
	}
	/* Fin de la définition de la classe. */
