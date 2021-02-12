<?php
	header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['nom_notion'])){
		$sql = "INSERT INTO notion(NOM_NOTION) VALUES(?)";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['nom_notion']);

		echo $request->execute();
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";	
	
?>