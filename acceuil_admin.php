
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
		$x=null;
		

	?>

<header>
	<p>nos produit:</p>
	<a href = "#takis" >takis</a>
	<a href = "#bonbon" >bonbon</a>
	<a href = "#boisson" >boisson</a>
	<div >
		<span class ="icon imgcommande" id ="btn-commande" ></span>
	</div>
	</header>
	<div id = "commande-form-client" style='display:none;'>
	<?php
		$tb_cmd = "SELECT * FROM cmd ";
		$result_cmd = mysqli_query($conn, $tb_cmd);
		$row_cmd= mysqli_fetch_assoc($result_cmd);
		if (isset($row_cmd)){
			foreach ($result_cmd as $row_cmd){
				$j=$row_cmd['Nºcmd'];
				$client= $row_cmd['Nºclient'];
				$n_client = "SELECT NomUtilisateur,instagram FROM $tbname_c WHERE Nºclient='$client' ";
				$result_n_cl=mysqli_query($conn, $n_client);
				$row_n_cl = mysqli_fetch_assoc($result_n_cl);
				$idproduit= $row_cmd['Nºproduit'];
				$n_produit = "SELECT NomProduit,ImgProduit,PrixProduit FROM $tbname_p WHERE Nºproduit='$idproduit' ";
				$result_n_pr=mysqli_query($conn, $n_produit);
				$row_n_pr = mysqli_fetch_assoc($result_n_pr);

				echo "
					<div class='commande'>
						<img class='pr' src=".$row_n_pr['ImgProduit'].">
						<p>
						le client ".$row_n_cl['NomUtilisateur']." 
						a commandé:".$row_n_pr['NomProduit']." 
						de prix ".$row_n_pr['PrixProduit']."dh<br>
						voici son instagram <a href='https://www.instagram.com/".$row_n_cl['instagram']."/'  target='_blank'>".$row_n_cl['instagram']."</a>
						</p>
						<img  class='supprimer' id=supprimer_$j src='icone/supprimer.png'> 
					</div>";

					echo"
					<script>
						var supprimer_$j = document.getElementById('supprimer_$j');
						supprimer_$j.onclick = function() {
							var confirm_supp = confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');
							if (confirm_supp) {
								var xhr = new XMLHttpRequest();
								xhr.open('POST', 'fn_supp_cmd.php');
								xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
								xhr.onload = function() {
									location.reload();
								};
							xhr.send('cmd_id=$j');
							}
						};	
					</script>
					";	
			}
		}else{
			echo "<p>vous n avez aucune commande</p>";
		}
?>
	</div>

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
					$btncommande="<button  class=' blue_button' id='changer_info_$i'>changer les informations du produit</button>";
					$quantite_produit="<p>".$row["QuantiteProduit"]." article restant</p>";

					echo "<li>
					<h3>".$row["NomProduit"]."</h3>
					<p>".$row["DescriptionProduit"]."</p>
					<img id='imgproduit' src='".$row["ImgProduit"]."'> 
					<p>".$row["PrixProduit"]." dh</p>
					$btncommande
					$quantite_produit
					</li>";

					echo "
					<div class='info-form' id='info-form-$i' style='display:none;'>
						<h3>Information du produit</h3>
						<img id='imgproduit' src='".$row["ImgProduit"]."'>
						<form action='acceuil_admin.php' method='POST'>
							<label>Quantité du produit</label>
							<input type='number' id='quantiteproduit_$i' name='quantiteproduit' value='".$row["QuantiteProduit"]."'>
							<input type='hidden' name='produit_id' value='".$i."'>
							
						</form>
						<button class='blue_button' id='enregistrer_$i'>Enregistrer</button>
						<button class='red_button'>Supprimer</button>
					</div>";
					
					echo "
					<script>
						var enregistrer_$i = document.getElementById('enregistrer_$i');
						enregistrer_$i.onclick = function() {
							var confirm_commande = confirm('Êtes-vous sûr de vouloir changer la quantité du produit ?');
							if (confirm_commande) {
								// exécuter la requête SQL pour mettre à jour la quantité
								var xhr = new XMLHttpRequest();
								xhr.open('POST', 'fn_enr.php');
								xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
								xhr.onload = function() {
									location.reload();
								};
								var quantite_pr = document.getElementById('quantiteproduit_$i').value; 
								xhr.send('produit_id=$i&quantite_pr=' + encodeURIComponent(quantite_pr)); 
							}
						};
					</script>
				";
				
					
						
						





						echo"
						<script>
							var body = document.querySelector('body');
							var mask = document.createElement('div');
							mask.classList.add('modal-mask');
							var changerinfo$i = document.getElementById('changer_info_$i');
							var infoForm$i = document.getElementById('info-form-$i');
							changerinfo$i.onclick = function() {
								if (infoForm$i.style.display === 'none') {
									infoForm$i.style.display = 'block';
									body.classList.add('modal-open');
									body.appendChild(mask);
									mask.onclick = function(){
										body.classList.remove('modal-open');
										body.removeChild(mask);	
										infoForm$i.style.display = 'none';
									}
								} else {
									infoForm$i.style.display = 'none';
									body.classList.remove('modal-open');
									body.removeChild(mask);
								}
							};
						</script>";
				}
			echo "		
			<li id='nouveau-produit-$typepr'>
			<h3>Ajouter un nouveau produit</h3>
			</li>";
			
			echo"	
			<script>
				var body = document.querySelector('body');
				var mask = document.createElement('div');
				mask.classList.add('modal-mask');
	
				var nouveauProduit$typepr = document.getElementById('nouveau-produit-$typepr');
				var nouveauProduitForm = document.getElementById('nouveau-produit-form');
	
				nouveauProduit$typepr.onclick = function() {
					if (nouveauProduitForm.style.display === 'none') {
					nouveauProduitForm.style.display = 'block';
					body.classList.add('modal-open');
					body.appendChild(mask);
					mask.onclick = function(){
						body.classList.remove('modal-open');
						body.removeChild(mask);	
						nouveauProduitForm.style.display = 'none';
						}
					} else {
					nouveauProduitForm.style.display = 'none';
					body.classList.remove('modal-open');
					body.removeChild(mask);
					}
				}
			</script>";
		echo"    <div id='nouveau-produit-form' style='display:none;'>
		<h3>Ajouter un nouveau produit</h3>
		<form action='acceuil_admin.php' method='POST' enctype='multipart/form-data'>
			<label for='nom-produit'>Nom du produit :</label>
			<input type='text' id='nom-produit' name='nom-produit' required>
			
			<br>
			<label for='description-produit'>Description :</label>
			<input type='text' id='description-produit' name='description-produit' required>
			<br>
			<label for='image'>Image du produit :</label>
			<input type='file' id='image' name='image' required>
			<br>
			<label for='prix-produit'>Prix :</label>
			<input type='number' id='prix-produit' name='prix-produit' required>
			<br>
			<button name='enregistrer' class=' blue_button' type='submit'>Ajouter</button>
		</form>
	</div>";
		if(isset($_POST['nom-produit'])) {
			$n_produit = $_POST['nom-produit'];
			$des_produit = $_POST['description-produit'];
			$nom_image = $_FILES['image']['name'];
			$chemin_image="img/$nom_image";
			move_uploaded_file($_FILES['image']['tmp_name'], $chemin_image);
			$pr_produit = $_POST['prix-produit'];

			$sql_add= "INSERT INTO $tbname_p (NomProduit, DescriptionProduit,TypeProduit ,ImgProduit,PrixProduit) VALUES ('$n_produit', '$des_produit','$typepr', '$chemin_image','$pr_produit')";
			mysqli_query($conn, $sql_add);
			unset($_POST);
			}
			
		
			

			
		echo"
				</ul>
			</div>";
	
	}

	?>
<script>
		var body = document.querySelector('body');
		var mask = document.createElement('div');
		mask.classList.add('modal-mask');
		var btn_cmd = document.getElementById('btn-commande');
		var cmd_form = document.getElementById('commande-form-client');
		btn_cmd.onclick = function() {
		if (cmd_form.style.display === 'none') {
			cmd_form.style.display = 'block';
			body.classList.add('modal-open');
			body.appendChild(mask);
			mask.onclick = function(){
				cmd_form.style.display = 'none';
				body.classList.remove('modal-open');
				body.removeChild(mask);	
			}
		}
	};
</script>






</body>
</html>