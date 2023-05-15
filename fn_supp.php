<?php
    include 'acceuil.php';
	$i = $_POST['produit_id'];
	$sql_del= "DELETE FROM cmd WHERE Nºproduit='".$i."' ";
	$result_del =mysqli_query($conn, $sql_del);
	
	$sql_ajout="UPDATE $tbname_p set QuantiteProduit=QuantiteProduit+1 WHERE Nºproduit=$i"; 
	$result_ajout=mysqli_query($conn, $sql_ajout);
	

?>