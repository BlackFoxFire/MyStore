<?php

	/*
	*
	* StatutManager.php
	* @Auteur : Christophe Dufour
	*
	* Fournit les services d'accès à la base de données
	* pour les statuts
	*
	*/
	
	/* Définition de la classe. */
	class StatutManager extends Manager {
		// Constantes de la classe
		const OBJET   = 0;
		const TABLEAU = 1;
		const DECROISSANT = -1;
		const NONTRIE     =  0;
		const CROISSANT   =  1;
		
		// Retourne une liste des statuts sous forme de tableau d'objet
		public function getListe($format = StatutManager::OBJET, $order = StatutManager::NONTRIE, $offset = 0, $limit = 0) {
			$sql = "select * from statuts";
			
			if(is_int($limit) && $limit != 0) {
				if(is_int($offset)) {
					$sql .= " limit " . (int) $offset . ", " . (int) $limit;
				}
			}
			
			if($order > 0)
				$sql .= " order by statut asc";
			
			if($order < 0)
				$sql .= " order by statut desc";
			
			$resultat = $this->executerRequete($sql);
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			foreach($resultat as $donnees) {
				if($format == StatutManager::OBJET)
					$statuts[$donnees['idStatut']] = new Statut($donnees);
				else
					$statuts[$donnees['idStatut']] = $donnees['statut'];
			}
			
			$resultat->closeCursor();
			
			return $statuts;
		}
		
		// Vérifie si un enregistrement existe
		public function existe($id) {
			$sql = "select idStatut from statuts where idStatut=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$nombre = $resultat->rowCount();
			
			$resultat->closeCursor();
			
			return $nombre;
		}
		
		// Permets de sauver une catégorie
		public function save(Statut $statut) {
			if($statut->estValide()) {
				if($statut->estNouveau()) {
					$this->add($statut);
				}
				else {
					$this->update($statut);
				}
			}
		}
		
		// Lit un enregistrement précis
		public function read($id) {
			$sql = "select * from statuts where idStatut=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			if($resultat->rowCount() == 0)
				return false;
			
			$statut = new Statut($resultat->fetch());
			$resultat->closeCursor();
			
			return $statut;
		}
		
		// Supprime une catégorie
		public function delete($id) {
			$sql = "delete from statuts where idStatut=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			
			return $resultat;
		}
		
		// Ajoute une catégorie dans la base de données
		protected function add(Statut $statut) {
			$sql = "insert into statuts(statut) values(?)";
			
			$resultat = $this->executerRequete($sql, array($statut->getStatut()));
			
			return $resultat;
		}
		
		// Mets à jour une catégorie de la base de données
		protected function update(Statut $statut) {
			$sql = "update statuts set statut=? where idStatut=?";
			
			$resultat = $this->executerRequete($sql, array($statut->getStatut(), $statut->getIdStatut()));
			
			return $resultat;
		}
		
	}
	/* Fin de la définition de la classe. */
