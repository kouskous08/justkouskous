<?php
    header('Location: index.php');
	include 'acceuil_admin.php';
	$i = $_POST['produit_id'];
	$sql_del= "DELETE FROM produit WHERE Nproduit='".$i."' ";
	$result_del =mysqli_query($conn, $sql_del);
	
	

?>