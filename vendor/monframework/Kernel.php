<?php

	/*
	*
	* Kernel.php
	* @Auteur : Christophe Dufour
	*
	* Coeur du framework
	* Charge la configuration principale de celui ci
	*
	*/
	
	// Définition de l'espace de nom
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	class Kernel extends MonFramework {
		
		// Constructeur de classe
		public function __construct() {
			require_once("../vendor/Foxy/Foxy.php");
		}
		
		// 
		public function chargement($environnement = null) {
			try {
				self::setEnvironnement($environnement);
				
				$requete = new Requete(array_merge($_GET, $_POST));
				$routeur = new Routeur();
				
				$controleur = $routeur->getControleur($requete);
				$action  = $routeur->getAction($requete);
				
				$controleur->executerAction($action);
			}
			catch(Exception $exception) {
				$vue = new Vue("erreur");
				$vue->render(array('messageErreur' => $exception->getMessage()));
			}
		}
		
	}
	/* Fin de la définition de la classe. */
