<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../Modelo/user.php";

$userModel = new user();

$_SESSION['error'] = '';

if (!isset($_POST['login'])) {

    include "../Vista/login.php";
    exit;

}

$username = trim($_POST['username']);
$password = $_POST['password']; 

$userData = $userModel->getUserByUsername($username);

if ($userData && password_verify($password, $userData['password'])) {

    session_regenerate_id(true);

    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['username'] = $userData['username'];
    
    header("Location: ../Controlador/home.php");
    exit;

} else {

   $_SESSION['error'] = "Usuario o contraseña incorrectos.";
    
    $_SESSION['old_user'] = $username;
    
    include "../Vista/login.php";
    exit;
}
?>