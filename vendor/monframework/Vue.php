<?php

	/*
	*
	* Vue.php
	* @Auteur : Christophe Dufour
	*
	* Classe modélisant une vue
	*
	*/
	
	// Définition de l'espace de nom
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	class Vue {
		
		// Fichier contenant la vue à afficher
		private $fichierVue;
		
		// Fichier contenant la vue à afficher
		private $fichier;
		
		private $template;
		
		// Controleur de classe
		public function __construct($fichier, $controleur = null) {
			$app = Configuration::getConfig('app');
			$fichier = str_replace("Action", "", $fichier);
			$this->fichier = $fichier . ".html";
			
			$dossierVues1 = "../src/" . $app . "/vues/";
			$dossierVues2 = "../src/" . $app . "/";
			
			if($controleur == null) {
				$this->template = new Foxy($dossierVues1);
			}
			else {
				$dossierVues2 .= $controleur . "/vues/";
				$this->template = new Foxy(array($dossierVues1, $dossierVues2));
			}
			
			$this->fichierVue = "../src/" . $app . "/";
			
			if($controleur != null) {
				$this->fichierVue = $this->fichierVue . $controleur . "/";
			}
			
			$this->fichierVue = $this->fichierVue . "vues/" . $fichier . ".php";
		}
		
		// Génère et affiche la vue en utilisant le moteur de template
		public function render($donnees) {
			$donnees['racineWeb'] = Configuration::getConfig('appDir');
			
			$this->template->load($this->fichier);
			
			$donnees['contenu'] = $this->template->render($donnees);
			
			$this->template->load("gabarit.html", false);
			
			echo $this->template->render($donnees);
		}
		
		// Génère et affiche la vue
		public function generer($donnees) {
			
			$contenu = $this->genererFichier($this->fichierVue, $donnees);
			
			$app = Configuration::getConfig('app');
			$gabarit = "../src/" . $app . "/vues/gabarit.php";
			
			$racineWeb = Configuration::getConfig('appDir');
			
			$vue = $this->genererFichier($gabarit, array('racineWeb' => $racineWeb, 'contenu' => $contenu));
			echo $vue;
		}
		
		// Génère un fichier vue et renvoie le résultat produit
		private function genererFichier($fichier, $donnees) {
			if(file_exists($fichier)) {
				extract($donnees);
				
				ob_start();
				require $fichier;
				
				return ob_get_clean();
			}
			else {
				throw new Exception("Fichier '$fichier' introuvables.");
			}
		}
		
		// Nettoie une valeur insérée dans une page HTML
		public function nettoyer() {
			return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
		}
		
	}
	/* Fin de la définition de la classe. */
