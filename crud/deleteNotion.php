<?php
	header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['id'])){
		// Vérifier si notion rattaché à une projet
		$sql = "SELECT * FROM traite
				WHERE ID_NOTION = ?";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['id']);
		if ($request->execute()){
			$sql2 = "DELETE FROM traite
					WHERE ID_NOTION = ?";
			$request2 = $pdo->prepare($sql2);
			$request2->bindParam(1, $_POST['id']);
			$request2->execute();
		}
		$sql3 = "DELETE FROM notion WHERE ID_NOTION = ?";
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