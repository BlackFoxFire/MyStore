<?php

	/*
	*
	* MonFramework.php
	* @Auteur : Christophe Dufour
	*
	* Classe mère de mon framework
	*
	*/
	
	// Définition de l'espace de nom
	// namespace BlackFox\MonFramework;
	
	/* Définition de la classe. */
	abstract class MonFramework {
		
		// Variable pour l'environnement de travail
		private static $environnement = 'dev';
		
		// Mofifie et retoune l'environnement de travail
		protected static function setEnvironnement($env = null) {
			if(!is_null($env)) {
				if($env == 'prod') {
					self::$environnement = $env;
				}
				else {
					throw new Exception("Paramètre d'environnement non reconnu : '$env'");
				}
			}
			else {
				return self::$environnement;
			}
		}
		
	}
	/* Fin de la définition de la classe. */