<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");


    require_once '../cnx.php';    

	if (isset($_POST['id'])){
		//Initialisation des variables 
		$image = null;
		$sql = null;

		//Si il y a une image a modifier 
		if (isset($_FILES['image']['name'])){
			//Récupération de la nouvel image 
			$image = $_FILES['image']['name'];

			//Recherche de l'ancienne image du villageois 
			$sql = 	"SELECT IMG FROM projet 
					WHERE ID_PROJET = ?";
			$request = $pdo->prepare($sql);
			$request->bindValue(1, $_POST['id']);
			$ancienneImage = null;
			if ($request->execute()){
				//Récupérer le résultat
				if ($data = $request->fetch()){
					$ancienneImage = $data['IMG'];
					//Supprimer le fichier de l'ancienne image
					if (file_exists('../images/'.$ancienneImage)){
						unlink('../images/'.$ancienneImage);
					}
					//Déplacer la nouvelle image dans le répertoire des images des villageois
					move_uploaded_file( $_FILES['image']['tmp_name'], "../images/".$image);
				}
			}
		}
		//Modification du projet dans la db 
		$sql = 	"UPDATE projet SET 
				ID_TYPE = ?,  
				NOM_PROJET = ?, 
				DATE = ?";
		if ($image){
			$sql .= ", IMG = ?";
		}
		$sql .= " WHERE ID_PROJET = ?";
		$request = $pdo->prepare($sql);
		$request->bindValue(1, $_POST['idType']);
		$request->bindValue(2, $_POST['nom']);
		$request->bindValue(3, $_POST['date']);

		if ($image){
			$request->bindValue(4, $image);
			$request->bindValue(5, $_POST['id']);
		}
		else
			$request->bindValue(4, $_POST['id']);
		echo $request->execute();
	}
	else {
		echo -1;
	}
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";	
?>