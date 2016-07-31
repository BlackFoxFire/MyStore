<?php

	/*
	*
	* CategorieManager.php
	* @Auteur : Christophe Dufour
	*
	* Fournit les services d'accès à la base de données
	* pour les catégories d'articles
	*
	*/
	
	/* Définition de la classe. */
	class CategorieManager extends Manager {
		
		// A EFFACER
		public function getListeCategories() {
			$sql = 'select * from categories order by categorie asc';
			
			$resultat = $this->executerRequete($sql);
			
			foreach($resultat as $donnees) {
				$categories[$donnees['idCategorie']] = $donnees['categorie'];
			}
			
			$resultat->closeCursor();
			
			return $categories;
		}
		
		// Retourne une liste des categories sous forme d'objet
		public function getListe($order = 0, $offset = 0, $limit = 0) {
			$sql = "select * from categories";
			
			if(is_int($limit) && $limit != 0) {
				if(is_int($offset)) {
					$sql .= " limit " . (int) $offset . ", " . (int) $limit;
				}
			}
			
			if($order > 0)
				$sql .= " order by categorie asc";
			
			if($order < 0)
				$sql .= " order by categorie desc";
			
			$resultat = $this->executerRequete($sql);
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			foreach($resultat as $donnees) {
				$categories[$donnees['idCategorie']] = new Categorie($donnees);
			}
			
			$resultat->closeCursor();
			
			return $categories;
		}
		
		// Vérifie si un enregistrement existe
		public function existe($id) {
			$sql = "select idCategorie from categories where idCategorie=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$nombre = $resultat->rowCount();
			
			$resultat->closeCursor();
			
			return $nombre;
		}
		
		// Permets de sauver une catégorie
		public function save(Categorie $categorie) {
			if($categorie->estValide()) {
				if($categorie->estNouveau()) {
					$this->add($categorie);
				}
				else {
					$this->update($categorie);
				}
			}
		}
		
		// Lit un enregistrement précis
		public function read($id) {
			$sql = "select * from categories where idCategorie=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			if($resultat->rowCount() == 0)
				return false;
			
			$categorie = new Categorie($resultat->fetch());
			$resultat->closeCursor();
			
			return $categorie;
		}
		
		// Supprime une catégorie
		public function delete($id) {
			$sql = "delete from categories where idCategorie=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			
			return $resultat;
		}
		
		// Ajoute une catégorie dans la base de données
		protected function add(Categorie $categorie) {
			$sql = "insert into categories(categorie) values(?)";
			
			$resultat = $this->executerRequete($sql, array($categorie->getCategorie()));
			
			return $resultat;
		}
		
		// Mets à jour une catégorie de la base de données
		protected function update(Categorie $categorie) {
			$sql = "update categories set categorie=? where idCategorie=?";
			
			$resultat = $this->executerRequete($sql, array($categorie->getCategorie(), $categorie->getIdCategorie()));
			
			return $resultat;
		}
		
	}
	/* Fin de la définition de la classe. */
