<?php

	require_once 'cnx.php';
	require_once 'classes/class.Type.php';

	// Ordre sql
	$sql = "SELECT * 
			FROM type_site";
	// preparation de la requete
	$requete = $pdo->prepare($sql);
	// Tableau pour les types
	$liste = array();
	// Test requete
	if($requete->execute()){
		
		while($donnees = $requete->fetch()){
			$type = new Type(
					$donnees['ID_TYPE'],
					$donnees['NOM_TYPE'],
			);
			// Ajouter le type à la liste
			$liste[] = $type;
		}		
	}
	// Génération du flux Json
	echo json_encode($liste);	
?>