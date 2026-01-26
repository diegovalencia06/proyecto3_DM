<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

require_once "../Modelo/user.php";

$user = new user();

$_SESSION['error'] = '';

if (!isset($_POST['register'])) {

    include "../Vista/register.php";
    exit;

} else {

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);


        if ($user->emailExists($email)) { 
    
            $_SESSION['error'] = "Este correo electrónico ya está registrado.";
            $_SESSION['old_data'] = $_POST;
            include "../Vista/register.php";
            exit;
            
            

        } elseif ($user->userExists($username)) {

            $_SESSION['error'] = "Este nombre de usuario ya está siendo utilizado.";
            $_SESSION['old_data'] = $_POST; 
            include "../Vista/register.php";
            exit;

        }
            
        if ($user->addUsers($_POST)) {
        
            $_SESSION['username'] = $username;
            unset($_SESSION['error']);
            unset($_SESSION['old_data']);
            
            header("Location: ../Controlador/home.php");
            exit;

        } else {
           
            $_SESSION['error'] = "Hubo un error al registrar el usuario. Inténtalo de nuevo.";
            include "../Vista/register.php";
            exit;

        }

    }