<?php

	/*
	*
	* SecuriseControleur.php
	* @Auteur : Christophe Dufour
	*
	* Classe abstraite des controleurs sécurisés
	* Fournit des services communs aux classes dérivées
	*
	*/
	
	// Définition de l'espace de nom
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	abstract class SecuriseControleur extends Controleur {
		
		// 
		public function executerAction($action) {
			parent::executerAction($action);
		}
		
	}
	/* Fin de la définition de la classe. */
