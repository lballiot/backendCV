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
		$sql = "SELECT * FROM projet WHERE ID_PROJET = ?";
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

			}
		}
		echo json_encode($projet);
	}
	else{
		echo -1;
	}

?>