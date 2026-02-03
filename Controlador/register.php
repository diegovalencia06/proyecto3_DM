<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../Modelo/user.php";
require_once "../Modelo/mailer.php";

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

    $nombre_imagen = 'default_user.png'; 

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        
        $temporal = $_FILES['foto_perfil']['tmp_name'];

        $check_imagen = getimagesize($temporal);
        
        if ($check_imagen === false) {
            $_SESSION['error'] = "El archivo subido no es una imagen válida.";
            $_SESSION['old_data'] = $_POST;
            include "../Vista/register.php";
            exit;
        }

        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $info_archivo = pathinfo($_FILES['foto_perfil']['name']);
        $extension = strtolower($info_archivo['extension']);

        if (!in_array($extension, $extensiones_permitidas)) {
            $_SESSION['error'] = "Solo se permiten archivos JPG, JPEG, PNG o GIF.";
            $_SESSION['old_data'] = $_POST;
            include "../Vista/register.php";
            exit;
        }

        $directorio_destino = "../img/usuarios/";
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }

        $nombre_imagen = time() . "_" . $username . "." . $extension;

        if (!move_uploaded_file($temporal, $directorio_destino . $nombre_imagen)) {
            $_SESSION['error'] = "Error al guardar la imagen.";
            include "../Vista/register.php";
            exit;
        }
    }
    
    $datos_usuario = $_POST;
    $datos_usuario['fotografia'] = $nombre_imagen; 

    if ($user->addUsers($datos_usuario)) {

        $mailer = new Mailer();

        $mailer->enviarBienvenida($email, $username);
    
        $_SESSION['username'] = $username;
        $_SESSION['fotografia'] = $nombre_imagen;
        unset($_SESSION['error']);
        unset($_SESSION['old_data']);
        
        header("Location: ../Controlador/home.php");
        exit;

    } else {
       
        $_SESSION['error'] = "Ha ocurrido un error.";
        include "../Vista/register.php";
        exit;

    }

}