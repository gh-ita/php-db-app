<?php
session_start();
$serveur = "localhost"; 
$utilisateur = "root";
$motDePasse = "";
$nomBaseDeDonnees = "gestionproduits";  

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
$query = "SELECT nom,prenom FROM compteproprietaire WHERE loginProp = :loginProp";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':loginProp', $_SESSION['login'], PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    $nom = $resultat['nom'];
    $prenom = $resultat['prenom'];
    
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta
      name="description"
      content="Web site created using php"
    />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Style/index.css">
    <title>Stock app</title>
  </head>
  <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Application produits</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="acceuil.php">Acceuil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ajouterProduit.php">Ajouter Produits</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../dao/logout.php">Quitter la session</a>
      </li>
    </ul>
  </div>
</nav>
    <?php
    date_default_timezone_set('Etc/GMT+1');
    $current_hour = date('G');
    $day_time = 6;
    $night_time = 18;
    if ($current_hour >= $day_time && $current_hour < $night_time) {
        echo "<h1>Bonjour ". $nom ." ".$prenom ."</h1>";
    } else {
        echo "<h1>Bonsoir ". $nom." ".$prenom ."</h1>";
    }
    ?>
    <table class="table table-striped">
    <h1>Produits</h1>
  <thead>
    <tr>
      <th scope="col">Reference</th>
      <th scope="col">Libelle</th>
      <th scope="col">Prix</th>
      <th scope="col">Date d'achat</th>
      <th scope="col">Photo</th>
      <th scope="col">Categorie</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $query = "SELECT * FROM produit ";
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo'
        <tr>
          <th scope="row">'.$row['reference'].'</th>
           <td>'.$row['libelle'].'</td>
           <td>'.$row['prixUnitaire'].'</td>
           <td>'.$row['dateAchat'].'</td>
           <td><img src =../../'.$row['photoProduit'].' style = "width : 50px;"></td>
           <td>'.$row['idCategorie'].'</td>
           <td><a href="modifierProduit.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
           <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
         </svg> </a>
         <a href ="../../dao/supprimerProduit.php?libelle='.$row['libelle'].'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
           <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
           <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
         </svg></a>
         </td>
        </tr>
        ';
    }
    ?>
  </tbody>
</table>
  <footer>
    <p>&copy; 2023 stock App. All rights reserved.</p>
</footer>
  </body>
</html>
