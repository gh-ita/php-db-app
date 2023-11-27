<?php
$error = isset($_GET['error']) ? $_GET['error'] : '';
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
    <h1>Authentification</h1>
    <div class = "formulaire">
    <form action = "../../dao/gestionprod.php" method = "post">
      <div class="mb-3">
        <?php
        if ($error == 1){
          echo'<h2>Login ou Mot de passe incorrect</h2>';
        }
        ?>
        <label for="exampleInputEmail1" class="form-label">Login</label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name ="loginProp">
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name = "motPasse">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <footer>
    <p>&copy; 2023 stock App. All rights reserved.</p>
</footer>
  </body>
</html>
