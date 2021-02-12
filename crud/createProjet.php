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
            
        }else{
            // Image non chargée
            echo -2;
        }
    }else{
        echo -1;
    }