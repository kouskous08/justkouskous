<?php
    include 'acceuil.php';
    $i = $_POST['produit_id'];

    $up_sql = "UPDATE $tbname_p SET QuantiteProduit = QuantiteProduit - 1 WHERE NºProduit = $i";
    $result = mysqli_query($conn, $up_sql);
	
	$N_U = "SELECT `Nºclient` FROM $tbname_c WHERE NomUtilisateur = '$user'";
	$result_u = mysqli_query($conn, $N_U);
	$row_u = mysqli_fetch_assoc($result_u);
	$Nºclient = $row_u['Nºclient'];
	$sql_c = "INSERT INTO cmd (`Nºclient`, `Nºproduit`) VALUES ($Nºclient, $i);";
	$result_c = mysqli_query($conn, $sql_c);

	$N_cl = "SELECT `Nºclient` FROM cmd WHERE Nºclient = '$Nºclient'";
	$result_cl = mysqli_query($conn, $N_cl);
	$row_cl = mysqli_fetch_assoc($result_cl);
	$num_rows_cl=mysqli_num_rows($row_cl);
	
	

?>