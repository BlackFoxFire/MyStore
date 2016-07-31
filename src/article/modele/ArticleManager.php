<?php

	/*
	*
	* ArticleManager.php
	* @Auteur : Christophe Dufour
	*
	* Classe
	*
	*/
	
	/* Définition de la classe. */
	class ArticleManager extends Manager {
		
		// Retourne la liste des articles
		public function getListeArticles($page = '*', $enregistrementParPage = 20) {
			$sql = 'select * from articles';
			
			if($page !== '*') {
				if(is_int($page) && is_int($enregistrementParPage)) {
					$pageMax = ceil($this->compterArticle() / $enregistrementParPage);
					
					if($page < 1) $page = 1;
					if($page > $pageMax) $page = $pageMax;
					
					$depart = ($page - 1) * $enregistrementParPage;
					
					$sql .= ' limit ' . $depart . ', ' . $enregistrementParPage;
				}
			}
			
			$articles = $this->executerRequete($sql);
			
			return $articles;
		}
		
		// Retourne une liste d'article sous forme d'objet Article
		public function getListe($order = 0, $offset = 0, $limit = 0) {
			$sql = "select * from articles";
			
			if(is_int($limit) && $limit != 0) {
				if(is_int($offset)) {
					$sql .= " limit " . (int) $offset . ", " . (int) $limit;
				}
			}
			
			if($order > 0)
				$sql .= " order by article asc";
			
			if($order < 0)
				$sql .= " order by article desc";
			
			$resultat = $this->executerRequete($sql);
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			foreach($resultat as $donnees) {
				$articles[] = new Article($donnees);
			}
			
			$resultat->closeCursor();
			
			return $articles;
		}
		
		// Renvoie le nombre total d'article
		public function count() {
			$sql = 'select count(idArticle) from articles';
			
			return $this->executerRequete($sql)->fetch()[0];
		}
		
		// Vérifie si un enregistrement existe
		public function existe($id) {
			$sql = "select idArticle from articles where idArticle=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$nombre = $resultat->rowCount();
			
			$resultat->closeCursor();
			
			return $nombre;
		}
		
		// Permets de sauver un article
		public function save(Article $article) {
			if($article->estValide()) {
				if($article->estNouveau()) {
					$this->add($article);
				}
				else {
					$this->update($article);
				}
			}
		}
		
		// Lit un enregistrement précis
		public function read($id) {
			$sql = "select * from articles where idArticle=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			
			if($resultat->rowCount() == 0)
				return false;
			
			$article = new Article($resultat->fetch());
			$resultat->closeCursor();
			
			return $article;
		}
		
		// Supprime un article de la base de données
		public function delete($id) {
			$sql = "delete from articles where idArticle=?";
			
			$resultat = $this->executerRequete($sql, array($id));
			
			return $resultat;
		}
		
		// Ajoute un article dans la base de données
		protected function add(Article $article) {
			$sql = "insert into articles(article, imageArticle, descriptionArticle, prix, lienEbay, idStatut,
				idType, idCategorie, idTaille, idCouleur) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			
			$resultat = $this->executerRequete($sql, array($article->getArticle()));
			
			return $resultat;
		}
		
		// Mets à jour un article de la base de données
		protected function update(Article $article) {
			$sql = "update articles set article=?, imageArticle=?, descriptionArticle=?, prix=?, lienEbay=?,
				idStatut=?, idType=?, idCategorie=?, idTaille=?, idCouleur=? where idArticle=?";
			
			$resultat = $this->executerRequete($sql, array($article->getArticle(), $article->getIdArticle()));
			
			return $resultat;
		}
		
		
		
		
		
		
		
		
		
		// Ajoute un article dans la base de données
		public function addArticle($article, $imageArticles, $descriptionArticle, $prix, $lienEbay, $idStatut, 
									$idType, $idCategorie, $idTaille, $idCouleur) {
			$sql = 'insert into articles(article, imageArticle, descriptionArticle, prix, lienEbay, idStatut,' .
					' idType, idCategorie, idTaille, idCouleur) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
			
			$resultat = $this->executerRequete($sql, array($article, $imageArticles, $descriptionArticle, $prix,
										$lienEbay, $idStatut, $idType, $idCategorie, $idTaille, $idCouleur));
		}
		
		// Retourne un article bien précis
		public function getArticle($idArticle) {
			
			$sql = 'select * from articles where idArticle=?';
			
			$resultat = $this->executerRequete($sql, array($idArticle));
			
			return $resultat->fetch();
		}
		
		// Mets à jour un article
		public function updateArticle($idArticle, $article, $imageArticles, $descriptionArticle, $prix, $lienEbay,
										$idStatut, $idType, $idCategorie, $idTaille, $idCouleur) {
			$sql = 'update articles set article=?, imageArticle=?, descriptionArticle=?, prix=?, lienEbay=?,' .
					' idStatut=?, idType=?, idCategorie=?, idTaille=?, idCouleur=? where idArticle=?';
			
			$resultat = $this->executerRequete($sql, array($article, $imageArticles, $descriptionArticle, $prix,
								$lienEbay, $idStatut, $idType, $idCategorie, $idTaille, $idCouleur, $idArticle));
			
			return $resultat;
		}
		
		// Recherche des articles suivant certains critères
		public function searchArticles($sql, $recherche, $page = '*', $enregistrementParPage = 20) {
			if($page !== '*') {
				if(is_int($page) && is_int($enregistrementParPage)) {
					$pageMax = ceil($this->compterArticle() / $enregistrementParPage);
					
					if($page < 1) $page = 1;
					if($page > $pageMax) $page = $pageMax;
					
					$depart = ($page - 1) * $enregistrementParPage;
					
					$sql .= ' limit ' . $depart . ', ' . $enregistrementParPage;
				}
			}
			
			$resultat = $this->executerRequete($sql, $recherche);
			
			return $resultat;
		}
		
		// Supprime un article bien précis
		public function deleteArticle($idArticle) {
			$sql = 'delete from articles where idArticle=?';
			
			$resultat = $this->executerRequete($sql, array($idArticle));
			
			return $resultat;
		}
		
		// Renvoie le nombre total d'article
		public function compterArticle() {
			$sql = 'select count(idArticle) from articles';
			
			return $this->executerRequete($sql)->fetch()[0];
		}
		
	}
	/* Fin de la définition de la classe. */
