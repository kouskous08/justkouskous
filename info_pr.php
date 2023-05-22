<?php
	session_start();
	$hostName = "localhost";
	$userName = "root";
	$password = "";
	$dbName = "just_kouskous";
	$tbname_p = "produit";
	$tbname_c = "client";
	$conn = new mysqli($hostName, $userName, $password, $dbName);
	$i = $_POST['i'];

	$compteur = 0;
	if ($_POST['nom-produit'] !== '') {
		$compteur++;
	}
	if ($_POST['description-produit'] !== '') {
		$compteur++;
	}
	if ($_POST['prix-produit'] !== '') {
		$compteur++;
	}
	if ($_POST['quantite-produit'] !== '') {
		$compteur++;
	}

	echo $compteur;
	$num = 0;
	while ($compteur != $num) {
		if (isset($_POST['nom-produit'])) {
			if ($_POST['nom-produit'] !== '') {
			$n_produit = $_POST['nom-produit'];
			$sql_up = "UPDATE $tbname_p SET NomProduit='".$n_produit."' WHERE Nºproduit='".$i."'";
			unset($_POST['nom-produit']);
			mysqli_query($conn, $sql_up);
        	}
		}

		if (isset($_POST['description-produit'])) {
			if ($_POST['description-produit'] !== '') {
			$des_produit = $_POST['description-produit'];
			$sql_up = "UPDATE $tbname_p SET DescriptionProduit='".$des_produit."' WHERE Nºproduit='".$i."'";
			unset($_POST['description-produit']);
			mysqli_query($conn, $sql_up);
			}	
		}

		if (isset($_POST['prix-produit'])) {
			if ($_POST['prix-produit'] !== '') {
				$pr_produit = $_POST['prix-produit'];
				$sql_up = "UPDATE $tbname_p SET PrixProduit='".$pr_produit."' WHERE Nºproduit='".$i."'";
				unset($_POST['prix-produit']);
				mysqli_query($conn, $sql_up);
			}
		} 		
		
		
		if (isset($_POST['quantite-produit'])) {
			if ($_POST['quantite-produit'] !== ''){
				$qt_produit = $_POST['quantite-produit'];
				$sql_up = "UPDATE $tbname_p SET QuantiteProduit='".$qt_produit."' WHERE Nºproduit='".$i."'";
				unset($_POST['quantite-produit']);
				mysqli_query($conn, $sql_up);
			}
		}

		
		$num++;
	}

	header('Location: acceuil_admin.php');
	exit;
?>
