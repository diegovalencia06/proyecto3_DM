<?php
// Controlador/google_callback.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../vendor/autoload.php';
require_once '../Modelo/config_google.php';
require_once '../Modelo/user.php'; 
require_once '../Modelo/mailer.php'; 

// Si ya estás logueado, al Home
if (isset($_SESSION['username'])) {
    header("Location: ../Controlador/home.php");
    exit;
}

$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URL);
$client->addScope("email");
$client->addScope("profile");

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
}

try {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['error'])) {
        $_SESSION['error'] = "Sesión caducada. Inténtalo de nuevo.";
        header("Location: ../Vista/login.php");
        exit;
    }

    $client->setAccessToken($token['access_token']);

    // DATOS DE GOOGLE
    $google_oauth = new Google\Service\Oauth2($client); 
    $google_account_info = $google_oauth->userinfo->get();

    $google_id = $google_account_info->id;
    $email     = $google_account_info->email;
    $imagen    = $google_account_info->picture;

    // Instanciamos el modelo
    $userModel = new user();

    // ==========================================================
    // LÓGICA DE NOMBRE DE USUARIO INTELIGENTE
    // ==========================================================
    
    // 1. Probamos con la parte delantera del email (ej: "juan.perez")
    $base_username = strstr($email, '@', true);
    $username_final = $base_username;

    // 2. ¿Existe ya ese usuario en la BD?
    if ($userModel->userExists($username_final)) {
        // SI EXISTE: Le añadimos un número aleatorio para hacerlo único
        // Ej: "juan.perez_482"
        $username_final = $base_username . "_" . rand(100, 999);
        
        // (Opcional) Si eres muy perfeccionista, podrías hacer un bucle while 
        // aquí por si el _482 también existiera, pero es estadísticamente casi imposible.
    }
    
    // ==========================================================

    // GESTIÓN DE BASE DE DATOS
    
    // CASO A: ¿Ya existe por ID de Google? (Login recurrente)
    $usuario_existente = $userModel->getUserByGoogleId($google_id);

    if ($usuario_existente) {
        $_SESSION['username']   = $usuario_existente['username']; 
        $_SESSION['fotografia'] = $usuario_existente['fotografia'];
        $_SESSION['email']      = $usuario_existente['email'];
        
    } else {
        // CASO B: ¿Existe el email? (Vincular)
        if ($userModel->emailExists($email)) {
            $userModel->updateGoogleId($email, $google_id);
            $_SESSION['username']   = $username_final; 
            $_SESSION['fotografia'] = $imagen;
            $_SESSION['email']      = $email;

        } else {
            // CASO C: REGISTRO NUEVO
            $datos = [
                'username'    => $username_final,
                'email'       => $email,
                'fotografia'  => $imagen,
                'google_id'   => $google_id
            ];
            
            $resultado = $userModel->addUserGoogle($datos);

            if (!$resultado) {
                die("Error al guardar. Verifica la base de datos.");
            }

            // Correo de bienvenida
            $mailer = new Mailer();
            // Le saludamos con el nombre base ("Hola juan.perez") no con el número
            $mailer->enviarBienvenida($email, $base_username); 

            $_SESSION['username']   = $username_final;
            $_SESSION['fotografia'] = $imagen;
            $_SESSION['email']      = $email;
        }
    }

    header("Location: ../Controlador/home.php");
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Error de conexión.";
    header("Location: ../Vista/login.php");
    exit;
}
?>