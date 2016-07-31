<?php

	/*
	*
	* CouleurManager.php
	* @Auteur : Christophe Dufour
	*
	* Fournit les services d'accès à la base de données
	* pour les couleurs d'articles
	*
	*/
	
	/* Définition de la classe. */
	class CouleurManager extends Manager {
		// Constantes de la classe
		const OBJET   = 0;
		const TABLEAU = 1;
		const DECROISSANT = -1;
		const NONTRIE     =  0;
		const CROISSANT   =  1;
		
		// Retourne une liste des couleurs sous forme d'objet
		public function getListe($format = CouleurManager::OBJET, $order = CouleurManager::NONTRIE, $offset = 0, $limit = 0) {
			$sql = "select * from couleurs";
			
			if(is_int($limit) && $limit != 0) {
				if(is_int($offset)) {
					$sql .= " limit " . (int) $offset . ", " . (int) $limit;
				}
			}
			
			if($order > 0)
				$sql .= " order by couleur asc";
			
			if($order < 0)
				$sql .= " order by couleur desc";
			
			$resultat = $this->executerRequete($sql);
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			foreach($resultat as $donnees) {
				if($format == CouleurManager::OBJET)
					$couleurs[$donnees['idCouleur']] = new Couleur($donnees);
				else
					$couleurs[$donnees['idCouleur']] = $donnees['couleur'];
			}
			
			$resultat->closeCursor();
			
			return $couleurs;
		}
		
		// Vérifie si un enregistrement existe
		public function existe($id) {
			$sql = "select idCouleur from couleurs where idCouleur=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$nombre = $resultat->rowCount();
			
			$resultat->closeCursor();
			
			return $nombre;
		}
		
		// Permets de sauver une catégorie
		public function save(Couleur $couleur) {
			if($couleur->estValide()) {
				if($couleur->estNouveau()) {
					$this->add($couleur);
				}
				else {
					$this->update($couleur);
				}
			}
		}
		
		// Lit un enregistrement précis
		public function read($id) {
			$sql = "select * from couleurs where idCouleur=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			if($resultat->rowCount() == 0)
				return false;
			
			$couleur = new Couleur($resultat->fetch());
			$resultat->closeCursor();
			
			return $couleur;
		}
		
		// Supprime une catégorie
		public function delete($id) {
			$sql = "delete from couleurs where idCouleur=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			
			return $resultat;
		}
		
		// Ajoute une catégorie dans la base de données
		protected function add(Couleur $couleur) {
			$sql = "insert into couleurs(couleur) values(?)";
			
			$resultat = $this->executerRequete($sql, array($couleur->getCouleur()));
			
			return $resultat;
		}
		
		// Mets à jour une catégorie de la base de données
		protected function update(Couleur $couleur) {
			$sql = "update couleurs set couleur=? where idCouleur=?";
			
			$resultat = $this->executerRequete($sql, array($couleur->getCouleur(), $couleur->getIdCouleur()));
			
			return $resultat;
		}
		
	}
	/* Fin de la définition de la classe. */
