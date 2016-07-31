<?php

	/*
	*
	* TypeManager.php
	* @Auteur : Christophe Dufour
	*
	* Fournit les services d'accès à la base de données
	* pour les type d'articles
	*
	*/
	
	/* Définition de la classe. */
	class TypeManager extends Manager {
		// Constantes de la classe
		const OBJET   = 0;
		const TABLEAU = 1;
		const DECROISSANT = -1;
		const NONTRIE     =  0;
		const CROISSANT   =  1;
		
		// Retourne une liste de type d'article sous forme d'objet Type
		public function getListe($format = TypeManager::OBJET, $order = TypeManager::NONTRIE, $offset = 0, $limit = 0) {
			$sql = "select * from types";
			
			if(is_int($limit) && $limit != 0) {
				if(is_int($offset)) {
					$sql .= " limit " . (int) $offset . ", " . (int) $limit;
				}
			}
			
			if($order > 0)
				$sql .= " order by type asc";
			
			if($order < 0)
				$sql .= " order by type desc";
			
			$resultat = $this->executerRequete($sql);
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			foreach($resultat as $donnees) {
				if($format == TypeManager::OBJET)
					$types[$donnees['idType']] = new Type($donnees);
				else
					$types[$donnees['idType']] =$donnees['type'];
			}
			
			$resultat->closeCursor();
			
			return $types;
		}
		
		// Vérifie si un enregistrement existe
		public function existe($id) {
			$sql = "select idType from types where idType=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$nombre = $resultat->rowCount();
			
			$resultat->closeCursor();
			
			return $nombre;
		}
		
		// Permets de sauver un type d'article
		public function save(Type $type) {
			if($type->estValide()) {
				if($type->estNouveau()) {
					$this->add($type);
				}
				else {
					$this->update($type);
				}
			}
		}
		
		// Lit un enregistrement précis
		public function read($id) {
			$sql = "select * from types where idType=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			if($resultat->rowCount() == 0)
				return false;
			
			$type = new Type($resultat->fetch());
			$resultat->closeCursor();
			
			return $type;
		}
		
		// Supprime un type d'article de la base de données
		public function delete($id) {
			$sql = "delete from types where idType=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			
			return $resultat;
		}
		
		// Ajoute un type d'article de la base de données
		protected function add(Type $type) {
			$sql = "insert into types(type) values(?)";
			
			$resultat = $this->executerRequete($sql, array($type->getType()));
			
			return $resultat;
		}
		
		// Mets à jour un type d'article de la base de données
		protected function update(Type $type) {
			$sql = "update types set type=? where idType=?";
			
			$resultat = $this->executerRequete($sql, array($type->getType(), $type->getIdType()));
			
			return $resultat;
		}
		
	}
	/* Fin de la définition de la classe. */
