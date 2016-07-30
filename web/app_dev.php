<?php

	/*
	* app_dev.php
	* @Auteur : Christophe Dufour
	* 
	* Controleur frontal en mode de devellopement de mon framework
	*
	*/
	
	// Importation de la classe Kernel
	// use BlackFox\MonFramework\Kernel;
	
	/* Test l'adresse ip du client afin de voir si on est bien autorisé a ouvrir cette page */
	if (isset($_SERVER['HTTP_CLIENT_IP']) || isset($_SERVER['HTTP_X_FORWARDED_FOR']) || 
		!(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', 'fe80::1', '::1', '192.168.77.10']) || 
		php_sapi_name() === 'cli-server'))
	{
		header('HTTP/1.0 403 Forbidden');
		exit("Vous n'êtes pas autorisé à accéder à ce fichier.");
	}
	
	// Charge la fonction d'autochargement des classes du framework
	require_once('../vendor/monframework/AutoLoad.php');
	
	// // Chargement du coeur
	$kernel = new Kernel();
	$kernel->chargement();
