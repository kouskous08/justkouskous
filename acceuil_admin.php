
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
		
        if($_SESSION['user']!="kouskous_ferkous"){
			header('Location: index.php');
		}
        
		

	?>

<header>
	<p>nos produit:</p>
	<a href = "#takis" class="lien-glissant" >takis</a>
	<a href = "#bonbon" class="lien-glissant" >bonbon</a>
	<a href = "#boisson" class="lien-glissant" >boisson</a>
	<div  id='icone'>
		<span class ="icon imgcommande" id ="btn-commande" ></span>
		<span class ="icon imgajout" id ="btn-ajout" ></span>
	</div>
	</header>
	<div id = "commande-form-client" style='display:none;'>
		<?php
			$tb_cmd = "SELECT * FROM cmd ";
			$result_cmd = mysqli_query($conn, $tb_cmd);
			$row_cmd= mysqli_fetch_assoc($result_cmd);
			if (isset($row_cmd)){
				foreach ($result_cmd as $row_cmd){
					$j=$row_cmd['Ncmd'];
					$client= $row_cmd['Nclient'];
					$n_client = "SELECT NomUtilisateur,instagram FROM $tbname_c WHERE Nclient='$client' ";
					$result_n_cl=mysqli_query($conn, $n_client);
					$row_n_cl = mysqli_fetch_assoc($result_n_cl);
					$idproduit= $row_cmd['Nproduit'];
					$n_produit = "SELECT NomProduit,ImgProduit,PrixProduit FROM $tbname_p WHERE Nproduit='$idproduit' ";
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
	<div id='nouveau-produit-form' style='display:none;'>
		<h3>Ajouter un nouveau produit</h3>
		<form action='nouv_pr.php' method='POST' enctype='multipart/form-data'>
			<label for='nom-produit'>Nom du produit :</label>
			<input type='text' id='nom-produit' name='nom-produit' required>
			<br>
			<label for='description-produit'>Description :</label>
			<input type='text' id='description-produit' name='description-produit' required>
			<br>
			<label for='type-produit'>type produit:</label>
			<select id="type-produit" name="type-produit">
				<option value="takis">Takis</option>
				<option value="bonbon">Bonbon</option>
				<option value="boisson">Boisson</option>
			</select>
			<br>
			<label for='image'>Image du produit :</label>
			<input type='file' id='image' name='image' required>
			<br>
			<label for='prix-produit'>Prix :</label>
			<input type='number' id='prix-produit' name='prix-produit' required>
			<br>
			<label for='quantite-produit'>quantité produit :</label>
			<input type='number' id='quantite-produit' name='quantite-produit' required>
			<br>
			<button name='enregistrer' class=' blue_button' type='submit'>Ajouter</button>
		</form>
	</div>
	</div>



	<div class="content">
		<?php
			$typespr=["takis","bonbon","boisson"];
			
			
			foreach ($typespr as $typepr){

			
				echo "
					<div id='$typepr'> 
						<h2>$typepr</h2>     
						<ul>";

						$sql = "SELECT NProduit,NomProduit, PrixProduit, DescriptionProduit,ImgProduit,QuantiteProduit,date FROM $tbname_p WHERE TypeProduit ='$typepr'";
						$result =mysqli_query($conn, $sql);

						foreach ($result as $row) {
							$i= $row["NProduit"];//num produit
							$infopr="<button  class=' blue_button' id='changer_info_$i'>changer info du produit</button>";
							$quantite_produit="<p>".$row["QuantiteProduit"]." article restant</p>";
							$img_path=$row["ImgProduit"];
							
							$date_pr=$row["date"];
							$date_pr=new DateTime($date_pr);//le jour lorsque le produit a ete ajouter
							$date_pr_3j=$date_pr->add(new DateInterval('P3D'));//j ai ajouter 3 jrs
							$date_pr_3j=$date_pr_3j->format('Y-m-d H:i:s');
							
							$date = new DateTime();//aujourdui
							$newTimezone = new DateTimeZone('Africa/Casablanca');
							$date->setTimezone($newTimezone);
							$date=$date->format('Y-m-d H:i:s');
							
							if($date_pr_3j>$date){//pour que le produit soit nouveau sa date +3jrs doit etre superieur a aujourd'hui
								echo "<li>
								<img id='nouv_produit' src='icone/nouv.png'>
								<h3>".$row["NomProduit"]."</h3>
								<p>".$row["DescriptionProduit"]."</p>
								<img class='imgproduit' src='".$img_path."'> 
								<p>".$row["PrixProduit"]." dh</p>
								$infopr
								$quantite_produit
								</li>";	
							}else{
								echo "<li>
								<h3>".$row["NomProduit"]."</h3>
								<p>".$row["DescriptionProduit"]."</p>
								<img class='imgproduit' src='".$img_path."'> 
								<p>".$row["PrixProduit"]." dh</p>
								$infopr
								$quantite_produit
								</li>";
							}

							echo "
							<div class='info-form' id='info-form-$i' style='display:none;'>
								<h3>Information du produit</h3>
								<img class='imgproduit' src='".$img_path."'>
								<form action='info_pr.php' method='POST' >
								<input type='hidden' name='i' value='$i'>
									<label for='nom-produit'>Nom du produit :</label>
									<input type='text' id='nom-produit' name='nom-produit'  placeholder='".$row['NomProduit']."' ='".$row['NomProduit']."' >
									<br>
									<label for='description-produit'>Description :</label>
									<input type='text' id='description-produit' name='description-produit'  placeholder='".$row['DescriptionProduit']."' >
									<br>
									<label for='prix-produit'>Prix :</label>
									<input type='number' id='prix-produit' name='prix-produit'  placeholder='".$row['PrixProduit']."' >
									<br>
									<label for='quantite-produit'>quantité produit :</label>
									<input type='number' id='quantite-produit' name='quantite-produit'  placeholder='".$row['QuantiteProduit']."' >
									<br>
									<div class='bouton-container'>
									<button name='enregistrer' class='blue_button' id='enregistrer_$i' type='submit'>Enregistrer</button>
									<button class='red_button' id='supprimer_$i'>Supprimer</button>
								  </div>
								</form>

							</div>"; 
						echo "
						<script>
							var supprimer_$i= document.getElementById('supprimer_$i');
							supprimer_$i.onclick = function() {
								var confirm_commande = confirm('Êtes-vous sûr de vouloir supprimer le produit ?');
								if (confirm_commande) {
									// exécuter la requête SQL pour mettre à jour la quantité
									var xhr = new XMLHttpRequest();
									xhr.open('POST', 'fn_supp_pr.php');
									xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
									xhr.onload = function() {
										location.reload();
									};
									xhr.send('produit_id=$i'); 
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
<script>
		var body = document.querySelector('body');
		var mask = document.createElement('div');
		mask.classList.add('modal-mask');
		var btn_ajout = document.getElementById('btn-ajout');
		var ajout_form = document.getElementById('nouveau-produit-form');
		btn_ajout.onclick = function() {
		if (ajout_form.style.display === 'none') {
			ajout_form.style.display = 'block';
			body.classList.add('modal-open');
			body.appendChild(mask);
			mask.onclick = function(){
				ajout_form.style.display = 'none';
				body.classList.remove('modal-open');
				body.removeChild(mask);	
			}
		}
	};
</script>
</body>
</html>