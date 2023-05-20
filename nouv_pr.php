<?php
			session_start();
			$hostName = "localhost";
			$userName = "root";
			$password = "";
			$dbName = "just_kouskous";
			$tbname_p = "produit";
			$tbname_c = "client";
			$conn = new mysqli($hostName,$userName,$password,$dbName);
	
	if(isset($_POST['enregistrer'])) {
		$n_produit = $_POST['nom-produit'];
		$des_produit = $_POST['description-produit'];
		$tppr=$_POST['type-produit'];
		$nom_image = $_FILES['image']['name'];
		$chemin_image="img/$nom_image";
		move_uploaded_file($_FILES['image']['tmp_name'], $chemin_image);
		$pr_produit = $_POST['prix-produit'];
		$qt_produit = $_POST['quantite-produit'];
		$sql_add= "INSERT INTO $tbname_p (NomProduit, DescriptionProduit,TypeProduit ,ImgProduit,PrixProduit,QuantiteProduit) VALUES ('$n_produit', '$des_produit','$tppr', '$chemin_image','$pr_produit','$qt_produit')";
		mysqli_query($conn, $sql_add);
		header('Location: acceuil_admin.php');
	}
?>