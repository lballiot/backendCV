<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

	require_once '../cnx.php';
	
    if(isset($_POST["nom"])){

		$image = $_FILES['image']['name'];

        if(move_uploaded_file( $_FILES['image']['tmp_name'], "images/".$image)){           

            $sql = "INSERT INTO projet(NOM_PROJET, DATE, IMG, ID_TYPE)
                    VALUES(?, ? ,?, ?)";
            $requete = $pdo->prepare($sql);
            $requete->bindParam(1, $_POST['nom']);
            $requete->bindParam(2, $_POST['date']);
            $requete->bindParam(3, $image);
            $requete->bindParam(4, $_POST['idType']);
            echo $requete->execute();
            
        }else{
            // Image non chargée
            echo -2;
        }
    }else{
        echo -1;
	}
?>


<?php
    header("Access-Control-Allow-Origin: *");

    require_once 'cnx.php';    

	if (isset($_POST['id'])){
		//Initialisation des variables 
		$image = null;
		$sql = null;

		//Si il y a une image a modifier 
		if (isset($_FILES['image']['name'])){
			//Récupération de la nouvel image 
			$image = $_FILES['image']['name'];
			//Recherche de l'ancienne image du villageois 
			$sql = 	"SELECT IMAGE FROM projet 
					WHERE ID_PROJET = ?";
			$request = $pdo->prepare($sql);
			$request->bindValue(1, $_POST['id']);
			$ancienneImage = null;
			if ($request->execute()){
				//Récupérer le résultat
				if ($data = $request->fetch()){
					$ancienneImage = $data['IMAGE'];
					//Supprimer le fichier de l'ancienne image
					if (file_exists('images/'.$ancienneImage)){
						unlink('images/'.$ancienneImage);
					}
					//Déplacer la nouvelle image dans le répertoire des images des villageois
					move_uploaded_file( $_FILES['image']['tmp_name'], "images/".$image);
				}
			}
		}
		//Modification du villageois dans la db 
		$sql = 	"UPDATE projet SET 
				ID_TYPE = ?,  
				NOM_PROJET = ?, 
				DATE = ?";
		if ($image){
			$sql .= ", IMAGE = ?";
		}
		$sql .= " WHERE ID_VILLAGEOIS = ?";
		$request = $pdo->prepare($sql);
		$request->bindValue(1, $_POST['idType']);
		$request->bindValue(2, $_POST['nom']);
		$request->bindValue(4, $_POST['date']);

		if ($image){
			$request->bindValue(7, $image);
			$request->bindValue(8, $_POST['id']);
		}
		else
			$request->bindValue(7, $_POST['id']);


		           $sql = "INSERT INTO projet(NOM_PROJET, DATE, IMAGE, ID_TYPE)
                    VALUES(?, ? ,?, ?)";
            $requete = $pdo->prepare($sql);
            $requete->bindParam(1, $_POST['nom']);
            $requete->bindParam(2, $_POST['date']);
            $requete->bindParam(3, $image);
			$requete->bindParam(4, $_POST['idType']);
			

		echo $request->execute();
	}
	else 
		echo -1;
?>