<?php
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['nom_type'])){
		$sql = "INSERT INTO type_site(NOM_TYPE) VALUES(?)";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['nom_type']);

		echo $request->execute();
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";	
	
?>