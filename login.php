<!DOCTYPE html>
<html>
<head>
	<title>connexion</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="icon"href="icone/logo.png">
</head>
<body>
	<div class="container" id="login-container">
		<h1>connexion</h1>
		<form action="login.php" method="POST">
			<label for="username">utilisateur:</label>
			<input type="text" name="username" id="username" required>
			<label for="password">mot de passe:</label>
			<input type="password" name="password" id="password" required>
			<?php
				session_start();//commencer nouvel session
				
				
				//les information de ma base de donnees
				$hostName = "localhost";
				$userName = "root";
				$password= "";
				$dbName = "just_kouskous";
				$tbname = "client";
				//la connexion a ma base de donnees
				$conn = new mysqli($hostName, $userName, $password, $dbName);
				if(isset($_POST['username'])) {// savoir si l utilisateur est poste (existe)
					$username = $_POST['username'];
					$user_password = $_POST['password'];


					$sql_check_u = "SELECT * FROM $tbname WHERE NomUtilisateur = '$username'";
					$result_u = mysqli_query($conn, $sql_check_u);
					$sql_check_p = "SELECT MDP FROM $tbname WHERE NomUtilisateur = '$username'";
					$result_p=mysqli_query($conn, $sql_check_p);
					$row = mysqli_fetch_assoc($result_p);
					if (isset($row["MDP"])){
						$MDP = $row["MDP"];


						if ($result_u) {
							
							if($username==="kouskous_ferkous"){
							
								if($user_password=="mamak2008"){

									$_SESSION['user'] = $username;
									header('Location: acceuil_admin.php');
									exit;
								}else{

									echo '<p class="erreur">Mot de passe incorrect</p>';
								}
							}
							elseif (mysqli_num_rows($result_u) > 0) {
								if ($user_password==$MDP) {
									
									$_SESSION['user'] = $username;
									header('Location: acceuil.php');
									exit;
								} else {
									
									echo '<p class="erreur">Mot de passe incorrect</p>';
								}
							} else {
								
								echo '<p class="erreur">Nom d utilisateur inconnu</p>';
							}
						}
					}
				}
			?>
			<button>se connecter</button>
		</form>

		<p>vous n'avez pas de compte  <a href="index.php">inscrivez-vous</a></p>
	</div>
</body>
</html>

