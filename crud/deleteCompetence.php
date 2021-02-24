<?php
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';

	if (isset($_POST['id'])){
		// Vérifier si compétence rattaché à une projet
		$sql = "SELECT * FROM utilise
				WHERE ID_COMPETENCE = ?";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['id']);
		if ($request->execute()){
			// Supprimer liaison avec le projet
			$sql2 = "DELETE FROM utilise
					WHERE ID_COMPETENCE = ?";
			$request2 = $pdo->prepare($sql2);
			$request2->bindParam(1, $_POST['id']);
			$request2->execute();
		}
		$sql3 = "DELETE FROM competence
				WHERE ID_COMPETENCE = ?";
		$request3 = $pdo->prepare($sql3);
		$request3->bindParam(1, $_POST['id']);

		echo $request3->execute();
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";	
	
?>