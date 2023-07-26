<?php
    header('Location: index.php');
	include 'acceuil_admin.php';
	$j = $_POST['cmd_id'];
	$sql_del= "DELETE FROM cmd WHERE Ncmd='".$j."'";
	$result_del =mysqli_query($conn, $sql_del);

	
	

	

?>