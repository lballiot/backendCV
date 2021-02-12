<?php
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['nom_type'])){
		$sql = 	"UPDATE type_site SET NOM_TYPE = ?
				WHERE ID_TYPE = ?";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['nom_type']);
		$request->bindParam(2, $_POST['id_type']);

		echo $request->execute();
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";		
?>