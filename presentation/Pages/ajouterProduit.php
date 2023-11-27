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
$query = "SELECT * FROM categorie";
$stmt = $connexion->prepare($query);
$stmt->execute();
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
    <link rel="stylesheet" href="../Style/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <title>Stock app</title>
  </head>
  <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <h1>Ajouter Produit</h1>
    <div class = "formulaire">
    <form action = "ajouterProduit.php" method = "POST" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Libelle</label>
      <input type="text" class="form-control" id="inputEmail4" placeholder="libelle" name ="libelle">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Prix unitaire</label>
      <input type="number" class="form-control" id="inputPassword4" placeholder="Prix" name ="prixUnitaire">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Date d'achat</label>
      <input type="date" class="form-control" id="inputEmail4" placeholder="date" name ="dateAchat">
    </div>
    <div class="mb-3">
     <label for="formFile" class="form-label">Photo produit</label>
     <input class="form-control" type="file" id="formFile" name ="photoProduit">
    </div>
  </div>
  <div class="form-row">
  <label for="inputState">Categorie</label>
    <div class="input-group mb-2 mr-sm-2">
      <select id="inputState" class="form-control" name = 'idCategorie'>
        <option selected>Choose...</option>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . htmlspecialchars($row['idCategorie']) . '">'.$row['idCategorie'].'</option>
            ';
        }
        ?>
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Ajouter</button>
</form>
  </div>
  </body>
  <?php
  $targetFolder = "../../images/";
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $libelle = $_POST['libelle'];
    $photoProduit = $_FILES['photoProduit'];
    $uniqueFileName = $photoProduit['name'];
    $targetPath = $targetFolder . $uniqueFileName;
    $bdPath = 'images/'. $uniqueFileName;
    $prixUnitaire = $_POST['prixUnitaire'];
    $dateAchat = $_POST['dateAchat'];
    $idCategorie = $_POST['idCategorie'];
    var_dump($idCategorie);
    // enregistrer l image dans le dossier
    move_uploaded_file($photoProduit["tmp_name"], $targetPath);
    //enregistrer les données dans la BD
    $query = "INSERT INTO produit (libelle, prixUnitaire, dateAchat, photoProduit, idCategorie) 
          VALUES (:libelle, :prixUnitaire, :dateAchat, :photoProduit, :idCategorie)";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
    $stmt->bindParam(':prixUnitaire', $prixUnitaire, PDO::PARAM_STR);
    $stmt->bindParam(':dateAchat', $dateAchat, PDO::PARAM_STR);
    $stmt->bindParam(':photoProduit', $bdPath, PDO::PARAM_STR);
    $stmt->bindParam(':idCategorie', $idCategorie, PDO::PARAM_STR);
    if ($stmt->execute()) {
        header("Location:acceuil.php");
        exit();
    } else {
        echo "Error inserting record.";
    }

  }
    
    ?>
</html>
