<?php

	require_once 'classes/class.Type.php';

	// Objet PDO
	$pdo = new PDO(
		'mysql:host=localhost;dbname=db_bloc2-projets;charset=utf8',
		'root', 
		'root'
	); 

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