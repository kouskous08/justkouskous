
<!DOCTYPE html>
<html lang="en">
<head>
<title>just_kouskous</title>
<link rel="icon"href="icone/logo.png">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="acceuil_style.css">
</head>

<body>
<?php
		session_start();
		$hostName = "localhost";
		$userName = "root";
		$password = "";
		$dbName = "just_kouskous";
		$tbname_p = "produit";
		$tbname_c = "client";
		$conn = new mysqli($hostName,$userName,$password,$dbName);
		

		
	?>

  	<header>
	<p>nos produit:</p>
	<a href = "#takis" >takis</a>
	<a href = "#bonbon" >bonbon</a>
	<a href = "#boisson" >boisson</a>
	<div >
		<span class ="icon imgcommande" id ="btn-commande-client" ></span>
	</div>
	</header>
	<?php 
			$user=$_SESSION['user'];
			$N_U = "SELECT Nºclient FROM $tbname_c WHERE NomUtilisateur = '$user'";
			$result_u = mysqli_query($conn, $N_U);
			$row_u = mysqli_fetch_assoc($result_u);
			$Nºclient = $row_u['Nºclient'];
			$N_cl = "SELECT Nºclient FROM cmd WHERE Nºclient = '$Nºclient'";
			$result_cl = mysqli_query($conn, $N_cl);
			$num_rows_cl=mysqli_num_rows($result_cl);	
	?>
	<div id = "commande-form-client" style='display:none;'>
	<?php
		if($num_rows_cl==0){
			echo "<p>vous n'avez aucune commande pour le moment</p>";
		}else{

			echo "<p>les produit commandé sont:</p>";

			$Cmd= "SELECT Nºproduit FROM cmd WHere Nºclient='$Nºclient' ";
			
			$result_cmd=mysqli_query($conn, $Cmd);
			

			
			foreach ($result_cmd as $produit_cmd){
				foreach($produit_cmd as $produit_cmd){
					$sql_pr="SELECT Nºproduit,NomProduit,DescriptionProduit,ImgProduit,PrixProduit FROM $tbname_p WHERE Nºproduit='$produit_cmd' ";
					$result_pr= mysqli_query($conn, $sql_pr);
					
					$numrow_pr=mysqli_num_rows($result_pr);

					foreach ($result_pr as $info_pr ){
						$i= $info_pr['Nºproduit'];
						echo "
						<div>	
						<img class= 'pr' src=".$info_pr["ImgProduit"].">
						<h3>1X &nbsp;</h3>
						<p>  ".$info_pr["NomProduit"]." 
						à prix de ".$info_pr["PrixProduit"]."dh </p>
						<img class='supprimer' id=supprimer_$i src='icone/supprimer.png'>
						</div>
						";
						
						echo"
						<script>
							var supprimer_$i = document.getElementById('supprimer_$i');
							supprimer_$i.onclick = function() {
								var confirm_supp = confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');
								if (confirm_supp) {
									var xhr = new XMLHttpRequest();
									xhr.open('POST', 'fn_supp.php');
									xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
									xhr.onload = function() {
										location.reload();
									};
								xhr.send('produit_id=$i');
								}
							};	
						</script>
						";	
						}
					}
				}
			}

	?>
	</div>
	


	</div>
	<?php

			if ($num_rows_cl>=2){
				echo "<p class=msg>vous avez atteint le nombre de commande par personne s'il vous plait attendez jusqu'â que vos commandes soient livrées</p>";
			}elseif($num_rows_cl==1){
				echo"<p class=msg>il vous reste une commande pour atteindre la limite </p>";
			};
	?>

  <div class="content">
	<?php
  	$typespr=["takis","bonbon","boisson"];
	foreach ($typespr as $typepr){

	
		echo "
			<div id='$typepr'> 
				<h2>$typepr</h2>     
				<ul>";
			
				

				$sql = "SELECT NºProduit,NomProduit, PrixProduit, DescriptionProduit,ImgProduit,QuantiteProduit FROM $tbname_p WHERE TypeProduit ='$typepr'";
				$result =mysqli_query($conn, $sql);

				foreach ($result as $row) {
					$i= $row["NºProduit"];//num produit
					
					if($num_rows_cl>=2){
						$btncommande="<button  class=' red_button' id='limit'>vous avez atteint la limite de commande</button>";
						$quantite_produit="<p>".$row["QuantiteProduit"]." article restant</p>";
					}elseif($row["QuantiteProduit"] > 0){
						$btncommande="<button  class=' blue_button' id='commander-$i'>commander</button>";
						$quantite_produit="<p>".$row["QuantiteProduit"]." article restant</p>";
						
					}else{
						$btncommande="<button  class=' red_button' id='out_of_stock'>out of stock</button>";
						$quantite_produit=null;

					};
					
					
					echo "<li>
					<h3>".$row["NomProduit"]."</h3>
					<p>".$row["DescriptionProduit"]."</p>
					<img id='imgproduit' src='".$row["ImgProduit"]."'> 
					<p>".$row["PrixProduit"]." dh</p>
					$btncommande
					$quantite_produit
					</li>";
				
		

					if (isset($_SESSION['user'])) {	
						$user=$_SESSION['user'];
						$insta_u="SELECT Instagram FROM $tbname_c WHERE NomUtilisateur='$user'";
						$result_i=mysqli_query($conn, $insta_u);
						$row_i = mysqli_fetch_assoc($result_i);
						if ($row_i!=null){
							foreach ($row_i as $a){
								$a;
							};


							echo "
							<div class=commander-form id=commander-form-$i style='display:none;' >
								<h3>commande</h3>
								<img id='imgproduit' src='".$row["ImgProduit"]."'>
								<p>votre produit est ".$row["NomProduit"]." à ".$row["PrixProduit"]." dh</p>
								<p>nous allons vous contacter dans instagram avec cet utilisateur: $a</p>	
								<button class='blue_button' id='btn_oui_$i' >oui</button>
								<button class='red_button 'id='btn_non_$i' >non</button>
							</div>";
							echo "
							<script>
								var btn_oui_$i = document.getElementById('btn_oui_$i');
								btn_oui_$i.onclick = function() {
									var confirm_commande = confirm('Êtes-vous sûr de vouloir commander ce produit ?');
									if (confirm_commande) {
										// exécuter la requête SQL pour mettre à jour la quantité
										var xhr = new XMLHttpRequest();
										xhr.open('POST', 'fn_oui.php');
										xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
										xhr.onload = function() {
											location.reload();
										};
										xhr.send('produit_id=$i');
									}
								};
								var btn_non_$i = document.getElementById('btn_non_$i');
								btn_non_$i.addEventListener('click', function() {
									if (commanderForm$i.style.display === 'block') {
										commanderForm$i.style.display = 'none';
										body.classList.remove('modal-open');
										body.removeChild(mask);
									}
								});
							</script>";

						}
						

						}else{
							echo "<div class=commander-form id=commander-form-$i style='display:none;' >
									<h3>commande</h3>
									<img id='imgproduit' src='".$row["ImgProduit"]."'>
									<p>votre produit est ".$row["NomProduit"]." à ".$row["PrixProduit"]." dh</p>
									<p>vous n'ête pas connecter s'il vous plait connecter vous </p>
									<a href='login.php'><button class='  blue_button'>connecter vous</button></a>						
									</div>";

						};
						echo"<script>
						var body = document.querySelector('body');
						var mask = document.createElement('div');
						mask.classList.add('modal-mask');
						var commander$i = document.getElementById('commander-$i');
						var commanderForm$i = document.getElementById('commander-form-$i');
						commander$i.onclick = function() {
							if (commanderForm$i.style.display === 'none') {
								commanderForm$i.style.display = 'block';
								body.classList.add('modal-open');
								body.appendChild(mask);
								mask.onclick = function(){
									commanderForm$i.style.display = 'none';
									body.classList.remove('modal-open');
									body.removeChild(mask);	
								}
							} else {
								commanderForm$i.style.display = 'none';
								body.classList.remove('modal-open');
								body.removeChild(mask);
							}
						};
					</script>";
				}

			
		echo"
				</ul>
			</div>";
	}
	?>

		
    </div>
<script>
		var body = document.querySelector('body');
		var mask = document.createElement('div');
		mask.classList.add('modal-mask');
		var btn_cmd_cl = document.getElementById('btn-commande-client');
		var cmd_form_cl = document.getElementById('commande-form-client');
		btn_cmd_cl.onclick = function() {
		if (cmd_form_cl.style.display === 'none') {
			cmd_form_cl.style.display = 'block';
			body.classList.add('modal-open');
			body.appendChild(mask);
			mask.onclick = function(){
				cmd_form_cl.style.display = 'none';
				body.classList.remove('modal-open');
				body.removeChild(mask);	
			}
		}
	};
</script>

</body>
</html>