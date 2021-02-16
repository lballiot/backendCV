<?php
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['id'])){
		$sql = 	"UPDATE notion SET NOM_NOTION = ?
				WHERE ID_NOTION = ?";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['nom_notion']);
		$request->bindParam(2, $_POST['id']);

		echo $request->execute();
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";		
?>