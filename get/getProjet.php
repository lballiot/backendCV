<?php
// Pour tester à la fin de l'url mettre ?id=1
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    
	require_once '../classes/class.Projet.php';

	if (isset($_POST['id']))
		$_GET['id'] = $_POST['id'];
	else {
		if (isset($_GET['id']))
		 $_POST['id'] = $_GET['id'];
	}

	if (isset($_POST['id'])){
		//Recherchez le projet par son id 
		$sql = "SELECT * FROM projet, type_site
			WHERE projet.ID_TYPE = type_site.ID_TYPE
			AND ID_PROJET = ?";
		//Préparation de la recette 
		$request = $pdo->prepare($sql);
		//On remplace le paramètre ? par la valeur
		$request->bindValue('1', $_POST['id']);
		$projet = null;
		if ($request->execute()){
			//Récupérez le résultat 
			if ($data = $request->fetch()){
				$projet = new Projet(
					$data['ID_PROJET'],
					$data['NOM_PROJET'],
					$data['DATE'],
					$host."images/".$data['IMG'],
				);
				$type = new Type(
					$data['ID_TYPE'],
					$data['NOM_TYPE']
				);
				$projet->setLeTypeDuProjet($type);

				// Get notion
				$sql2 = "SELECT * FROM traite, notion, projet
						WHERE projet.ID_PROJET = ?
						AND traite.ID_PROJET = projet.ID_PROJET
						AND notion.ID_NOTION = traite.ID_NOTION";
				$request2 = $pdo->prepare($sql2);
				$request2->bindValue('1', $_POST['id']);
				$listNotion = array();
				if ($request2->execute()){
					while ($data2 = $request2->fetch()) {
						$notion = new Notion(
							$data2['ID_NOTION'],
							$data2['NOM_NOTION']
						);
						$listNotion[] = $notion;
					}
					$projet->setLesNotionsTraitees($listNotion);
				}

				// Get skill
				$sql3 = "SELECT * FROM utilise, competence, projet
						WHERE projet.ID_PROJET = ?
						AND utilise.ID_PROJET = projet.ID_PROJET
						AND competence.ID_COMPETENCE = utilise.ID_COMPETENCE";
				$request3 = $pdo->prepare($sql3);
				$request3->bindValue('1', $_POST['id']);
				$listSkill = array();
				if ($request3->execute()){
					while ($data3 = $request3->fetch()) {
						$competence = new Competence(
							$data3['ID_COMPETENCE'],
							$data3['NOM_COMPETENCE'],
							$data3['ICON_COMPETENCE']
						);
						$listSkill[] = $competence;
					}
					$projet->setLesCompetencesUtilises($listSkill);
				}
			}
		}
		echo json_encode($projet);
	}
	else{
		echo -1;
	}

?>