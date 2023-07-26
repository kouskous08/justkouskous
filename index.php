<!DOCTYPE html>
<html>
<head>
	<title>Inscription

	</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="icon"href="icone/logo.png">
</head>
<body>
	<div class="container">
	<?php
		session_start();
		// Configuration de la base de données
		$hostName = "localhost";//nom du administrateur
		$userName = "root";//nom d utilisateur
		$password = "";//mdp (il n y a pas)
		$dbName = "just_kouskous"; // nom de base de donne
		$tbname = "client";// nom de la table
		$conn = new mysqli($hostName,$userName,$password,$dbName); // connexion a  la base de donne de mysql


		
	?>
		<h1>Inscription</h1>
		<form action="index.php" id="register-container" method="POST">
			<label for="username">Nom d'utilisateur:</label>
			<input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required>
			<label for="insta">Ton Instagram:</label>
			<input type="text" name="insta" id="insta" placeholder=" exp: user1234" required >
			<p class="erreur">Attention! Ton Instagram est très important pour pouvoir te contacter!</p>
			<label for="password">Mot de passe:</label>
			<input type="password" name="password" id="password"  required>
			
			<?php
			
				
				$regex = '/^[a-zA-Z0-9_\-]+$/';//les caractere qu un utilisateur ne peux pas entrer dans le champ nom d utilisateur
				
	
				if(isset($_POST['username'])) {//si post utilisateur existe il va  faire les lignes suivantes
					$username = $_POST['username'];// la variable username =  va stocker  l utilisateur posté
					$insta = $_POST['insta'];
					$password = $_POST['password'];
					
					$sql_u="SELECT * FROM $tbname WHERE NomUtilisateur='$username'";
					$result_u= mysqli_query($conn, $sql_u);					
					
					$sql_i="SELECT * FROM $tbname WHERE Instagram='$insta'";
					$result_i= mysqli_query($conn, $sql_i);
					
					if (!preg_match($regex, $username)) {
						echo '<p class="erreur">Le nom d\'utilisateur ne doit pas contenir de caractères spéciaux </p>';
					}else{
							
							if (mysqli_num_rows($result_u) > 0) {

								echo '<p class="erreur">Le nom d utilisateur est déjà pris</p>';
							} else {
								if(mysqli_num_rows($result_i) > 0){
									echo'<p class="erreur">ce instagram est déjà utilisé par un autre utilisateur</p>';
								}else{
									if(strlen($password) < 8) {
										echo '<p class="erreur">Le mot de passe doit contenir au moins 8 caractères</p>';
									} else {
										$sql = "INSERT INTO $tbname (NomUtilisateur, instagram, MDP) VALUES ('$username', '$insta', '$password')";
										mysqli_query($conn, $sql);
										$_SESSION['user'] = $username;
										header('Location: acceuil.php');
									}
								}
							}
						}
					}
			?>
			<button type="submit">Enregistrer</button>
		</form>
		<p>Vous avez un compte? <a href="login.php">Connectez-vous</a></p>
	</div>
</body>
</html>
