<?php
//connexion a la BD

$serveur = "localhost"; 
$utilisateur = "root";
$motDePasse = "";
$nomBaseDeDonnees = "gestionproduits";  // Nom de la base de données

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// gestion des données d'authentification 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginProp = $_POST["loginProp"];
    $motPasse = $_POST["motPasse"];
    if ($loginProp == "" || $motPasse == ""){
        header("Location:../presentation/Pages/login");
        exit();
    }
    $query = "SELECT * FROM compteproprietaire WHERE loginProp = :loginProp and motPasse = :motPasse";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':loginProp', $loginProp, PDO::PARAM_STR);
    $stmt->bindParam(':motPasse', $motPasse, PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($resultat){
        session_start();
        $_SESSION['login'] = $loginProp;
        header("Location:../presentation/Pages/acceuil");
        exit();
    }
    else{
        header("Location:../presentation/Pages/login?error=1");
        exit();
    }
    $connexion = null;
} else {
    // Handle cases where the form wasn't submitted using POST
    echo "Form not submitted!";
}
?>
