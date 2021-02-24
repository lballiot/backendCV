<?php
	header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['id'])){

		// Vérifier si projet rattaché à une competence
		$sql = "SELECT * FROM utilise
				WHERE ID_PROJET = ?";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['id']);
		if ($request->execute()){
			// Supprimer liaison avec la compétence
			$sql2 = "DELETE FROM utilise
					WHERE ID_PROJET = ?";
			$request2 = $pdo->prepare($sql2);
			$request2->bindParam(1, $_POST['id']);
			$request2->execute();
		}

		// Vérifier si projet rattaché à une notion
		$sql = "SELECT * FROM traite
				WHERE ID_PROJET = ?";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['id']);
		if ($request->execute()){
			// Supprimer liaison avec la notion
			$sql2 = "DELETE FROM traite
					WHERE ID_PROJET = ?";
			$request2 = $pdo->prepare($sql2);
			$request2->bindParam(1, $_POST['id']);
			$request2->execute();
		}

		//Recherche de l'image du projet 
		$sql = 	"SELECT IMG FROM projet 
				WHERE ID_PROJET = ?";
		$request = $pdo->prepare($sql);
		$request->bindValue(1, $_POST['id']);
		$ancienneImage = null;
		if ($request->execute()){
			//Récupérer le résultat
			if ($data = $request->fetch()){
				$ancienneImage = $data['IMG'];
			}
		}
		//Supprimer le fichier de l'ancienne image
		if (file_exists('../images/'.$ancienneImage)){
			unlink('../images/'.$ancienneImage);
		}

		$sql = "DELETE FROM projet WHERE ID_PROJET = ?";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['id']);

		echo $request->execute();
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";	
	
?>