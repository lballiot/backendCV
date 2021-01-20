<?php

	require_once 'classes/class.Notion.php';

	// Objet PDO
	$pdo = new PDO(
		'mysql:host=localhost;dbname=db_bloc2-projets;charset=utf8',
		'root', 
		'root'
	); 

	// Ordre sql
    $sql = "SELECT * 
            FROM notion";
    // preparation de la requete
    $requete = $pdo->prepare($sql);
    // Tableau pour les notions
    $liste = array();
    // Test requete
    if($requete->execute()){
        
        while($donnees = $requete->fetch()){
            $notion = new Notion(
                $donnees['ID_NOTION'],
            	$donnees['NOM_NOTION'],                   
            );
			
			// Pour chaque notions, recherche de ses projets associés
            $sql = "SELECT *  
                FROM traite, projet 
                WHERE traite.ID_NOTION = ? 
                AND traite.ID_PROJET = projet.ID_PROJET ";
            
            $requete2 = $pdo->prepare($sql);
            $requete2->bindValue(1, $notion->getId());
            
            $lesProjets = array();
            if ($requete2->execute()) {
                // Parcours des résultats
                while ($donnees2 = $requete2->fetch()) {
                    
                    $projet = new Projet(
						$donnees2['ID_PROJET'],
						$donnees2['NOM_PROJET'],
						$donnees2['DATE'],
						$donnees2['IMG']                          
                    );

                    $lesProjets[] = $projet;
                }
            }
            $notion->setLesProjets($lesProjets);


            // Ajouter le notion à la liste
            $liste[] = $notion;
        }        
    }
    // Génération du flux Json
    echo json_encode($liste);
    
    
?>