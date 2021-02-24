<?php
// Pour tester à la fin de l'url mettre ?id=1
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    
	require_once '../classes/class.Notion.php';

	if (isset($_POST['id']))
		$_GET['id'] = $_POST['id'];
	else {
		if (isset($_GET['id']))
		 $_POST['id'] = $_GET['id'];
	}

	if (isset($_POST['id'])){
		//Recherchez la Notion par son id 
		$sql = "SELECT * FROM notion
				WHERE ID_NOTION = ?";
		//Préparation de la recette 
		$request = $pdo->prepare($sql);
		//On remplace le paramètre ? par la valeur
		$request->bindValue('1', $_POST['id']);
		$notion = null;
		if ($request->execute()){
			//Récupérez le résultat 
			if ($data = $request->fetch()){
				$notion = new Notion(
					$data['ID_NOTION'],
					$data['NOM_NOTION']
				);
				$sql2 = "SELECT * FROM notion, projet, traite 
						WHERE notion.ID_NOTION = ?
						AND traite.ID_NOTION = notion.ID_NOTION
						AND projet.ID_PROJET = traite.ID_PROJET";
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
					$notion->setLesProjets($listProject);
				}
			}
		}
		echo json_encode($notion);
	}
	else{
		echo -1;
	}

?>