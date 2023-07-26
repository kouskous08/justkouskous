<?php
    header('Location: index.php');
	include 'acceuil.php';
	$j = $_POST['cmd_id'];;
	$sql_i = "SELECT Nproduit FROM cmd WHERE Ncmd='$j' ";
	$result_i = mysqli_query($conn, $sql_i);
  
    while ($row = mysqli_fetch_assoc($result_i)) {
        $Nproduit = $row['Nproduit'];
    }

	
	$sql_ajout="UPDATE $tbname_p set QuantiteProduit=QuantiteProduit+1 WHERE Nproduit=$Nproduit"; 
	$result_ajout=mysqli_query($conn, $sql_ajout);
	$sql_del= "DELETE FROM cmd WHERE Ncmd='".$j."' ";
	$result_del =mysqli_query($conn, $sql_del);
	

?>