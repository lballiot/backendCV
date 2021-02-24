<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once '../cnx.php';

if(isset($_POST["nom"])){
	$image = $_FILES['image']['name'];

	if(move_uploaded_file( $_FILES['image']['tmp_name'], "../images/".$image)){           
		
		$sql = "INSERT INTO projet(ID_TYPE, NOM_PROJET, DATE, IMG)
				VALUES(?, ? ,?, ?)";
		$requete = $pdo->prepare($sql);
		$requete->bindParam(1, $_POST['idType']);
		$requete->bindParam(2, $_POST['nom']);
		$requete->bindParam(3, $_POST['date']);
		$requete->bindParam(4, $image);
		echo $requete->execute();

		// Récupération de l'id du projet venant d'être créer
		$sql2 = "SELECT ID_PROJET FROM projet
				WHERE ID_TYPE = ? 
				AND NOM_PROJET = ?
				AND DATE = ?";
		$requete2 = $pdo->prepare($sql2);
		$requete2->bindParam(1, $_POST['idType']);
		$requete2->bindParam(2, $_POST['nom']);
		$requete2->bindParam(3, $_POST['date']);
		$requete2->execute();

		$idProjet = $requete2->fetch()[0];
		if (isset($_POST['idCompetences'])){
			$arrayComp = explode(',', $_POST['idCompetences']);
			
			for ($i=0; $i < count($arrayComp); $i++) { 
				$sql = "INSERT INTO utilise(ID_COMPETENCE, ID_PROJET) VALUES(?, ?)";
				$request = $pdo->prepare($sql);
				$request->bindParam(1, $arrayComp[$i]);
				$request->bindParam(2, $idProjet);

				echo $request->execute();
			}
		}
		if (isset($_POST['idNotions'])){
			$arrayNotion = explode(',', $_POST['idNotions']);
			
			for ($i=0; $i < count($arrayNotion); $i++) { 
				$sql = "INSERT INTO traite(ID_NOTION, ID_PROJET) VALUES(?, ?)";
				$request = $pdo->prepare($sql);
				$request->bindParam(1, $arrayNotion[$i]);
				$request->bindParam(2, $idProjet);

				echo $request->execute();
			}
		}
		}else{
		// Image non chargée
		echo -2;
	}
}else{
	echo -1;
}