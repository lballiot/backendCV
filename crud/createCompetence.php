<?php
    header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['nom_competence'])){
		$sql = "INSERT INTO competence(NOM_COMPETENCE, ICON_COMPETENCE) VALUES(?, ?)";
		$request = $pdo->prepare($sql);
		$request->bindParam(1, $_POST['nom_competence']);
		$request->bindParam(2, $_POST['icon_competence']);

		echo $request->execute();
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";	
	
?>