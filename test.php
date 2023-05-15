<?php
    		
			session_start();
			$hostName = "localhost";
			$userName = "root";
			$password = "";
			$dbName = "just_kouskous";
			$tbname_p = "produit";
			$tbname_c = "client";
			$conn = new mysqli($hostName,$userName,$password,$dbName);
			$tb_cmd = "SELECT * FROM cmd ";
			$result_cmd = mysqli_query($conn, $tb_cmd);
			$row_cmd= mysqli_fetch_assoc($result_cmd);
			if (isset($row_cmd)){
				foreach ($result_cmd as $row_cmd){
					$ipr=$row_cmd['Nºcmd'];
					print_r($row_cmd) ;
				}}




?>