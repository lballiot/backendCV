<?php
// Pour tester à la fin de l'url mettre ?id=1
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    
	require_once '../classes/class.Competence.php';

	if (isset($_POST['id']))
		$_GET['id'] = $_POST['id'];
	else {
		if (isset($_GET['id']))
		 $_POST['id'] = $_GET['id'];
	}

	if (isset($_POST['id'])){
		//Recherchez la competence par son id 
		$sql = "SELECT * FROM competence WHERE ID_COMPETENCE = ?";
		//Préparation de la recette 
		$request = $pdo->prepare($sql);
		//On remplace le paramètre ? par la valeur
		$request->bindValue('1', $_POST['id']);
		$competence = null;
		if ($request->execute()){
			//Récupérez le résultat 
			if ($data = $request->fetch()){
				$competence = new Competence(
					$data['ID_COMPETENCE'],
					$data['NOM_COMPETENCE'],
					$data['ICON_COMPETENCE']
				);
				$sql2 = "SELECT * FROM competence, projet, utilise 
						WHERE competence.ID_COMPETENCE = ?
						AND utilise.ID_COMPETENCE = competence.ID_COMPETENCE
						AND projet.ID_PROJET = utilise.ID_PROJET";
				$request2 = $pdo->prepare($sql2);
				$request2->bindValue('1', $_POST['id']);
				$listProject = array();
				if ($request2->execute()){
					while ($data2 = $request2->fetch()) {
						$project = new Projet(
							$data2['ID_PROJET'],
							$data2['NOM_PROJET'],
							$data2['DATE'],
							$host."images/".$data2['IMG'],
						);
						$listProject[] = $project;
					}
					$competence->setLesProjets($listProject);
				}
			}
		}
		echo json_encode($competence);
	}
	else{
		echo -1;
	}

?>