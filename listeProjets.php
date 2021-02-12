<?php
    header("Access-Control-Allow-Origin: *");

	require_once 'cnx.php';
	require_once 'classes/class.Projet.php';

	// Ordre sql
    $sql = "SELECT * 
            FROM projet";
    // preparation de la requete
    $requete = $pdo->prepare($sql);
    // Tableau pour les projets
    $liste = array();
    // Test requete
    if($requete->execute()){
        
        while($donnees = $requete->fetch()){
            $projet = new Projet(
                $donnees['ID_PROJET'],
				$donnees['NOM_PROJET'],
				$donnees['DATE'],
				$host."images/".$donnees['IMG']
			);
			
			// Pour chaque projet, recherche de ses compétences associés
            $sql = "SELECT *  
                FROM utilise, competence 
                WHERE utilise.ID_PROJET = ? 
                AND utilise.ID_COMPETENCE = competence.ID_COMPETENCE ";
            
            $requete2 = $pdo->prepare($sql);
            $requete2->bindValue(1, $projet->getId());
            
            $listeCompetences = array();
            if ($requete2->execute()) {
                // Parcours des résultats
                while ($donnees2 = $requete2->fetch()) {
                    
                    $competence = new Competence(
						$donnees2['ID_COMPETENCE'],
						$donnees2['NOM_COMPETENCE'],  
						$donnees2['ICON_COMPETENCE'],                       
					);
					$listeCompetences[] = $competence;
                }
            }
            $projet->setLesCompetencesUtilises($listeCompetences);

			// Pour chaque projet, recherche de son type
            $sql = "SELECT *  
                FROM projet, type_site 
                WHERE projet.ID_PROJET = ? 
                AND projet.ID_TYPE = type_site.ID_TYPE ";
            
            $requete3 = $pdo->prepare($sql);
            $requete3->bindValue(1, $projet->getId());
            
            $type = null;
            if ($requete3->execute()) {
                if ($donnees3 = $requete3->fetch()) {  
                    $type = new Type(
						$donnees3['ID_TYPE'],
						$donnees3['NOM_TYPE'],                        
					);
                }
			}
			$projet->setLeTypeDuProjet($type);

			// Pour chaque projet, recherche de ses notions associés
            $sql = "SELECT *  
                FROM traite, notion 
                WHERE traite.ID_PROJET = ? 
                AND traite.ID_NOTION = notion.ID_NOTION ";
            
            $requete4 = $pdo->prepare($sql);
            $requete4->bindValue(1, $projet->getId());
            
            $listeNotions = array();
            if ($requete4->execute()) {
                // Parcours des résultats
                while ($donnees4 = $requete4->fetch()) {
                    
                    $notion = new Notion(
						$donnees4['ID_NOTION'],
						$donnees4['NOM_NOTION'],                        
					);
					$listeNotions[] = $notion;
                }
			}
			$projet->setLesNotionsTraitees($listeNotions);
            $liste[] = $projet;
        }        
    }
    // Génération du flux Json
    echo json_encode($liste);
    
    
?>