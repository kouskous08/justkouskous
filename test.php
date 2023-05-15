<?php
    		
			session_start();
			$hostName = "localhost";
			$userName = "root";
			$password = "";
			$dbName = "just_kouskous";
			$tbname_p = "produit";
			$tbname_c = "client";
			$conn = new mysqli($hostName,$userName,$password,$dbName);
			$user="tarikouskous";
			$N_U = "SELECT Nºclient FROM $tbname_c WHERE NomUtilisateur = '$user'";
			$result_u = mysqli_query($conn, $N_U);
			$row_u = mysqli_fetch_assoc($result_u);
			$Nºclient = $row_u['Nºclient'];
			$N_cl = "SELECT Nºclient FROM cmd WHERE Nºclient = '$Nºclient'";
			$result_cl = mysqli_query($conn, $N_cl);
			$num_rows_cl=mysqli_num_rows($result_cl);	

			$tb_cmd = "SELECT * FROM cmd ";
			$result_cmd = mysqli_query($conn, $tb_cmd);
			$row_cmd= mysqli_fetch_assoc($result_cmd);
			if (isset($row_cmd)){
				foreach ($result_cmd as $row_cmd){
					
					$idclient= $row_cmd['Nºclient'];
					$n_client = "SELECT NomUtilisateur,instagram FROM $tbname_c WHERE Nºclient='$idclient' ";
					$result_n_cl=mysqli_query($conn, $n_client);
					$row_n_cl = mysqli_fetch_assoc($result_n_cl);
					$idproduit= $row_cmd['Nºproduit'];
					$n_produit = "SELECT NomProduit,ImgProduit,PrixProduit FROM $tbname_p WHERE Nºproduit='$idproduit' ";
					$result_n_pr=mysqli_query($conn, $n_produit);
					$row_n_pr = mysqli_fetch_assoc($result_n_pr);
	
					echo "
					<div class='commande'>
						<img  src=".$row_n_pr['ImgProduit'].">
						<p>
						le client ".$row_n_cl['NomUtilisateur']." 
						a commandé:".$row_n_pr['NomProduit']." 
						de prix ".$row_n_pr['PrixProduit']."
						voici son instagram <a href='https://www.instagram.com/".$row_n_cl['instagram']."/'  target='_blank'>".$row_n_cl['instagram']."</a>
						<img class='supprimer' id=supprimer_".$row_cmd['Nºcmd']." src='icone/supprimer.png'>
						</p> 
						</div>";
				}
			}else{
				echo "<p>vous n avez aucune commande</p>";
			}


?>