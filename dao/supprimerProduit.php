<?php
$serveur = "localhost"; 
$utilisateur = "root";
$motDePasse = "";
$nomBaseDeDonnees = "gestionproduits";  
$libelle = isset($_GET['libelle']) ? $_GET['libelle'] : '';

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
$query = "DELETE FROM produit WHERE libelle = :libelle";
$stmt = $connexion->prepare($query);
$stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
$stmt->execute();
header("Location:../presentation/Pages/acceuil");
exit();
?>