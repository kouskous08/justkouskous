<?php
header('Location: index.php');
include 'acceuil_admin.php';

// Vérifier que les données POST sont présentes
if(isset($_POST['quantite_pr']) && isset($_POST['produit_id'])) {
    
    // Récupérer les données POST
    $quantite = $_POST['quantite_pr'];
    $produit_id = $_POST['produit_id'];
    
    // Mettre à jour la quantité du produit dans la base de données
    $sql = "UPDATE $tbname_p SET QuantiteProduit = '$quantite' WHERE `Nproduit` = $produit_id";
    $result = mysqli_query($conn, $sql);
    
    // Vérifier si la mise à jour a réussi
    if($result) {
        echo "La quantité du produit a été mise à jour avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la mise à jour de la quantité du produit.";
    }
} else {
    echo "Les données POST ne sont pas présentes.";
}
?>
