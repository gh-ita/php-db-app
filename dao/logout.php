<?php
session_start();
unset($_SESSION['login']);
header('Location:../presentation/Pages/login.php');
?>