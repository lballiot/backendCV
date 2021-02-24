<?php
	header("Access-Control-Allow-Origin: *");

    require_once '../cnx.php';    

	if (isset($_POST['id'])){

		//Si delete
		if (isset($_POST['delete'])){
			$sql = "DELETE FROM utilise
					WHERE ID_COMPETENCE = ?
					AND ID_PROJET = ?";
			$request = $pdo->prepare($sql);
			$request->bindParam(1, $_POST['id']);
			$request->bindParam(2, $_POST['idProjet']);   
			echo $request->execute();
		}
		// sinon create
		else{
			// Vérification si projet déjà existant pour la competence
			$sql = "SELECT * FROM utilise 
					WHERE ID_COMPETENCE = ? 
					AND ID_PROJET = ?";
			$requete = $pdo->prepare($sql);
			$requete->bindParam(1, $_POST['id']);
			$requete->bindParam(2, $_POST['idProjet']);           
			$nbLignes = 0;
			if($requete->execute()) {
				while($donnees = $requete->fetch()) {
					$nbLignes++;
				}
			}
			if($nbLignes == 0){
				$sql = "INSERT INTO utilise(ID_COMPETENCE, ID_PROJET) VALUES(?, ?)";
				$request = $pdo->prepare($sql);
				$request->bindParam(1, $_POST['id']);
				$request->bindParam(2, $_POST['idProjet']);

				echo $request->execute();
			}
		}
	}
	else{
		echo -1;
	}

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";	
	
?>