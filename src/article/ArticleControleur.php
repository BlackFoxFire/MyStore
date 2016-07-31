<?php

	/*
	*
	* ArticleControleur.php
	* @Auteur : Christophe Dufour
	*
	* Contrôleur des actions liées aux articles
	*
	*/
	
	/* Définition de la classe. */
	class ArticleControleur extends Controleur {
		
		private $articleManager;
		private $categorieManager;
		private $couleurManager;
		private $statutManager;
		private $tailleManager;
		private $typeManager;
		
		private $categories;
		private $couleurs;
		private $statuts;
		private $tailles;
		private $types;
		
		// Constructeur de classe
		public function __construct() {
			$this->articleManager = new ArticleManager;
			$this->categorieManager = new CategorieManager;
			$this->couleurManager = new CouleurManager;
			$this->statutManager = new StatutManager;
			$this->tailleManager = new TailleManager;
			$this->typeManager = new TypeManager;
			
			// $this->categories = $this->categorieManager->getListeCategories();
			// $this->couleurs = $this->couleurManager->getListeCouleurs();
			// $this->statuts = $this->statutManager->getListeStatuts();
			// $this->tailles = $this->tailleManager->getListeTailles();
			// $this->types = $this->typeManager->getListeTypes();
			
			$this->categories = $this->categorieManager->getListe(1);
			$this->couleurs = $this->couleurManager->getListe(1);
			$this->statuts = $this->statutManager->getListe(1);
			$this->tailles = $this->tailleManager->getListe(1);
			$this->types = $this->typeManager->getListe(1);
		}
		
		// Action par defaut
		// Affiche la liste des articles
		public function indexAction() {
			$page = 1;
			
			if($this->requete->parametreExiste("id")) {
				if(is_numeric($this->requete->getParametre("id")))
					$page = (int) $this->requete->getParametre("id");
			}
			
			$pageMax = ceil($this->articleManager->count() / 20);
			
			if($page < 1) $page = 1;
			if($page > $pageMax) $page = $pageMax;
			
			
			$offset = ($page - 1) * 20;
			$articles = $this->articleManager->getListe(0, $offset, 20);
			
			$pagePrecedante = $page - 1;
			$pageSuivante = $page + 1;
			$pagesDispo = "";
			
			if($pageMax > 1) {
				$depart = 1;
				
				if($page - 4 > 1) $depart = $page - 4;
				$fin = $depart + 8;
				
				if($fin > $pageMax) {
					$fin = $pageMax;
					$depart = $fin - 8;
					if($depart < 1) $depart = 1;
				}
				
				for($i=$depart; $i<=$fin; $i++) {
					if($i != $page)
						$pagesDispo .= "<a href=\"Article/index/$i\">$i</a> ";
					else
						$pagesDispo .= "$i ";
				}
			}
			
			if(count($articles) == 0) {
				$aucunEnregistrement = true;
			}
			else {
				$aucunEnregistrement = false;
			}
			
			$this->render(array('aucunEnregistrement' => $aucunEnregistrement, 'articles' => $articles,
				'categories' => $this->categories, 'couleurs' => $this->couleurs, 'statuts' => $this->statuts,
				'tailles' => $this->tailles, 'types' => $this->types, 'page' => $page,
				'pagePrecedante' => $pagePrecedante, 'pageSuivante' => $pageSuivante, 'pageMax' => $pageMax,
				'pagesDispo' => $pagesDispo));
		}
		
		// Action appellée lorsqu'il n'y a aucun article a afficher.
		public function aucunArticleAction() {
			$this->genererVue(array('categories' => $this->categories, 'couleurs' => $this->couleurs,
			'statuts' => $this->statuts, 'tailles' => $this->tailles, 'types' => $this->types));
		}
		
		// Ajoute un article
		public function ajouterArticleAction() {
			$donnees = array('categories' => $this->categories, 'couleurs' => $this->couleurs,
			'statuts' => $this->statuts, 'tailles' => $this->tailles, 'types' => $this->types);
			
			if(isset($_POST['submit'])) {
				$articleValide = true;
				
				if(is_string($_POST['nomArticle']) && !empty($_POST['nomArticle'])) {
					$nomArticle = $_POST['nomArticle'];
					$donnees['nomArticle'] = $nomArticle;
				}
				else $articleValide = false;
				
				if(isset($_FILES['imageArticle']) && $_FILES['imageArticle']['error'] == 0) {
					$tailleMax = (1024 * 1024) * 10;
					
					$extentionValide = array('gif', 'jpeg', 'jpg', 'png');
					$extentionFichier = strtolower(  substr(  strrchr($_FILES['imageArticle']['name'], '.')  ,1)  );
					
					if($_FILES['imageArticle']['size'] <= $tailleMax && in_array($extentionFichier, $extentionValide))
						$imageArticle = "images/download/" . md5(uniqid('', true)) . '.' . $extentionFichier;
					else
						$articleValide = false;
					
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['prix'])) {
					$prix = (float) $_POST['prix'];
					$donnees['prix'] = $prix;
				}
				else $articleValide = false;
				
				if(true) {
					$lienEbay = $_POST['lienEbay'];
					$donnees['lienEbay'] = $lienEbay;
				}
				
				if(is_numeric($_POST['idType'])){
					$idType = (int) $_POST['idType'];
					$donnees['idType'] = $idType;
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idCategorie'])){
					$idCategorie = (int) $_POST['idCategorie'];
					$donnees['idCategorie'] = $idCategorie;
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idTaille'])){
					$idTaille = (int) $_POST['idTaille'];
					$donnees['idTaille'] = $idTaille;
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idCouleur'])){
					$idCouleur = (int) $_POST['idCouleur'];
					$donnees['idCouleur'] = $idCouleur;
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idStatut'])){
					$idStatut = (int) $_POST['idStatut'];
					$donnees['idStatut'] = $idStatut;
				}
				else $articleValide = false;
				
				if(is_string($_POST['descriptionArticle'])){
					$descriptionArticle = $_POST['descriptionArticle'];
					$donnees['descriptionArticle'] = $descriptionArticle;
				}
				
				if($articleValide) {
					if(move_uploaded_file($_FILES['imageArticle']['tmp_name'], $imageArticle)) {
						$this->articleManager->addArticle($nomArticle, $imageArticle, $descriptionArticle,
							$prix, $lienEbay, $idStatut, $idType, $idCategorie, $idTaille, $idCouleur);
						$articleSauve = true;
						
						$this->rediriger("Article", "articleSauve");
					}
					else {
						throw new Exception("Une erreure est survenue lors de l'envoie de l'image. <br />" .
											"L'article n'a pas été ajouté.");
					}
				}
			}
			
			$this->genererVue($donnees);
		}
		
		// L'article a bien été sauvé
		public function articleSauveAction() {
			$this->genererVue(array());
			// sleep(3);
			// $this->rediriger("Article", "ajouterArticle");
		}
		
		// Affiche un article bien précis
		public function afficherArticleAction() {
			$idArticle = $this->requete->getParametre("id");
			
			if(!is_numeric($idArticle) || $idArticle == 0)
				throw new Exception("Identifiant d'article non valide !");
			
			$idArticle = (int) $idArticle;
			
			if(!$this->articleManager->existeArticle($idArticle))
				throw new Exception("L'article n°$idArticle n'existe pas.");
			
			$article = $this->articleManager->getArticle($idArticle);
			
			$this->genererVue(array('article' => $article, 'categories' => $this->categories,
				'couleurs' => $this->couleurs, 'statuts' => $this->statuts,
				'tailles' => $this->tailles, 'types' => $this->types));
		}
		
		// Modifie un article existant
		public function modifierArticleAction() {
			$idArticle = $this->requete->getParametre("id");
			
			if(!is_numeric($idArticle) || $idArticle == 0)
				throw new Exception("Identifiant d'article non valide !");
			
			$idArticle = (int) $idArticle;
			
			if(!$this->articleManager->existe($idArticle))
				throw new Exception("L'article n°$idArticle n'existe pas.");
			
			$article = $this->articleManager->getArticle($idArticle);
			
			if(isset($_POST['submit'])) {
				$articleValide = true;
				
				if(is_string($_POST['nomArticle']) && !empty($_POST['nomArticle'])) {
					$nomArticle = $_POST['nomArticle'];
				}
				else $articleValide = false;
				
				if(isset($_FILES['imageArticle']) && $_FILES['imageArticle']['error'] == 0) {
					$tailleMax = (1024 * 1024) * 10;
					
					$extentionValide = array('gif', 'jpeg', 'jpg', 'png');
					$extentionFichier = strtolower(  substr(  strrchr($_FILES['imageArticle']['name'], '.')  ,1)  );
					
					if($_FILES['imageArticle']['size'] <= $tailleMax && in_array($extentionFichier, $extentionValide)) {
						if(self::setEnvironnement() == 'dev') {
							$imageArticle = "images/downloadDev/" . md5(uniqid('', true)) . '.' . $extentionFichier;
						}
						else {
							$imageArticle = "images/download/" . md5(uniqid('', true)) . '.' . $extentionFichier;
						}
						
						$ancienneImage = $article['imageArticle'];
						$imageModifiee = true;
					}
					else $articleValide = false;
					
				}
				else $imageArticle = $article['imageArticle'];
				
				if(is_numeric($_POST['prix'])) {
					$prix = (float) $_POST['prix'];
				}
				else $articleValide = false;
				
				if(true) {
					$lienEbay = $_POST['lienEbay'];
				}
				
				if(is_numeric($_POST['idType'])){
					$idType = (int) $_POST['idType'];
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idCategorie'])){
					$idCategorie = (int) $_POST['idCategorie'];
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idTaille'])){
					$idTaille = (int) $_POST['idTaille'];
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idCouleur'])){
					$idCouleur = (int) $_POST['idCouleur'];
				}
				else $articleValide = false;
				
				if(is_numeric($_POST['idStatut'])){
					$idStatut = (int) $_POST['idStatut'];
				}
				else $articleValide = false;
				
				if(is_string($_POST['descriptionArticle'])){
					$descriptionArticle = $_POST['descriptionArticle'];
				}
				
				if($articleValide) {
					if(isset($imageModifiee)) {
						if(move_uploaded_file($_FILES['imageArticle']['tmp_name'], $imageArticle)) {
							$this->articleManager->updateArticle($article['idArticle'], $nomArticle, $imageArticle,
													$descriptionArticle, $prix, $lienEbay, $idStatut, $idType,
													$idCategorie, $idTaille, $idCouleur);
							$articleSauve = true;
							if(file_exists($ancienneImage)) unlink($ancienneImage);
						}
						else {
							throw new Exception("Une erreure est survenue lors de l'envoie de l'image.<br />" .
												"L'article n'a pas été modifié.");
						}
					}
					else {
						$this->articleManager->updateArticle($article['idArticle'], $nomArticle, $imageArticle,
															$descriptionArticle, $prix, $lienEbay, $idStatut,
															$idType, $idCategorie, $idTaille, $idCouleur);
						$articleSauve = true;
					}
					
					$this->rediriger("Article", "articleModifie");
				}
			}
			
			$this->genererVue(array('article' => $article, 'categories' => $this->categories,
				'couleurs' => $this->couleurs, 'statuts' => $this->statuts,
				'tailles' => $this->tailles, 'types' => $this->types));
		}
		
		// L'article a bien été modifié
		public function articleModifieAction() {
			$this->genererVue(array());
			// sleep(3);
			// $this->rediriger("Article", "index");
		}
		
		// Supprime un article
		public function supprimerAction() {
			$idArticle = $this->requete->getParametre("id");
			
			if(!is_numeric($idArticle) || $idArticle == 0)
				throw new Exception("Identifiant d'article non valide !");
			
			$idArticle = (int) $idArticle;
			
			if(!$this->articleManager->existe($idArticle))
				throw new Exception("L'article n°$idArticle n'existe pas.");
			
			$article = $this->articleManager->read($idArticle);
			
			if($this->articleManager->delete($idArticle)) {
				if(file_exists($article->getImageArticle()))
					unlink($article->getImageArticle());
				$this->render();
			}
		}
		
		// Recherche des articles suivant certaine critères
		public function rechercherArticleAction($page = 1) {
			$sql = 'select * from articles where ';
			$recherche = null;
			$modif = false;
			
			if(is_numeric($_POST['idType']) && $_POST['idType'] != 0) {
				$sql .= 'idType=? ';
				$recherche[] = (int) $_POST['idType'];
				$modif = true;
			}
			
			if(is_numeric($_POST['idCategorie']) && $_POST['idCategorie'] != 0) {
				if ($modif) $sql .= 'and idCategorie=? ';
				else $sql .= 'idCategorie=? ';
				$recherche[] = (int) $_POST['idCategorie'];
				$modif = true;
			}
			
			if(is_numeric($_POST['idTaille']) && $_POST['idTaille'] != 0) {
				if ($modif) $sql .= 'and idTaille=? ';
				else $sql .= 'idTaille=? ';
				$recherche[] = (int) $_POST['idTaille'];
				$modif = true;
			}
			
			if(is_numeric($_POST['idCouleur']) && $_POST['idCouleur'] != 0) {
				if ($modif) $sql .= 'and idCouleur=? ';
				else $sql .= 'idCouleur=? ';
				$recherche[] = (int) $_POST['idCouleur'];
				$modif = true;
			}
			
			if(is_numeric($_POST['idStatut']) && $_POST['idStatut'] != 0) {
				if ($modif) $sql .= 'and idStatut=? ';
				else $sql .= 'idStatut=? ';
				$recherche[] = (int) $_POST['idStatut'];
				$modif = true;
			}
			
			if(is_string($_POST['chaineDeRecherche']) && !empty($_POST['chaineDeRecherche'])) {
				if($modif) $sql .= 'and article like ?';
				else $sql .= 'article like ?';
				$recherche[] = '%' . $_POST['chaineDeRecherche'] . '%';
			}
			
			if($sql == 'select * from articles where ') $sql .= '1';
			
			$articles = $this->articleManager->searchArticles($sql, $recherche);
			$pageMax = ceil($articles->rowCount() / 20);
			$articles->closeCursor();
			
			$articles = $this->articleManager->searchArticles($sql, $recherche, $page);
			
			if($articles->rowCount() == 0)
				$this->rediriger("Article", "aucunArticle");
			
			$this->genererVue(array('page' => $page, 'pageMax' => $pageMax, 'articles' => $articles,
				'categories' => $this->categories, 'couleurs' => $this->couleurs, 'statuts' => $this->statuts,
				'tailles' => $this->tailles, 'types' => $this->types));
			
			$articles->closeCursor();
		}
		
	}
	/* Fin de la définition de la classe. */
