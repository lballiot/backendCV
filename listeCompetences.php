<?php
    header("Access-Control-Allow-Origin: *");

	require_once 'cnx.php';
	require_once 'classes/class.Competence.php';

	// Ordre sql
    $sql = "SELECT * 
            FROM competence";
    // preparation de la requete
    $requete = $pdo->prepare($sql);
    // Tableau pour les competences
    $liste = array();
    // Test requete
    if($requete->execute()){
        
        while($donnees = $requete->fetch()){
            $competence = new Competence(
                $donnees['ID_COMPETENCE'],
            	$donnees['NOM_COMPETENCE'],                   
            	$donnees['ICON_COMPETENCE']
            );
			
			// Pour chaque competences, recherche de ses projets associés
            $sql = "SELECT *  
                FROM utilise, projet 
                WHERE utilise.ID_COMPETENCE = ? 
                AND utilise.ID_PROJET = projet.ID_PROJET ";
            
            $requete2 = $pdo->prepare($sql);
            $requete2->bindValue(1, $competence->getId());
            
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
            $competence->setLesProjets($lesProjets);

            $liste[] = $competence;
		}
	}
    // Génération du flux Json
    echo json_encode($liste);
    
    
?>