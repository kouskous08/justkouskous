<?php
echo"	
<div class='info-form' id='info-form-$i' style='display:none;'>
<h3>Information du produit</h3>
<form action='nouv_pr.php' method='POST' enctype='multipart/form-data'>
	<label for='nom-produit'>Nom du produit :</label>
	<input type='text' id='nom-produit' name='nom-produit' required>
	<br>
	<label for='description-produit'>Description :</label>
	<input type='text' id='description-produit' name='description-produit' required>
	<br>
	<label for='prix-produit'>Prix :</label>
	<input type='number' id='prix-produit' name='prix-produit' required>
	<br>
	<label for='quantite-produit'>quantité produit :</label>
	<input type='number' id='quantite-produit' name='quantite-produit' required>
	<br>
	<button name='enregistrer' class=' blue_button' type='submit'>Ajouter</button>
</form>
</div>";





?>