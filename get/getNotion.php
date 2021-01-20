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
		$sql = "SELECT * FROM notion WHERE ID_NOTION = ?";
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

			}
		}
		echo json_encode($notion);
	}
	else{
		echo -1;
	}

?>