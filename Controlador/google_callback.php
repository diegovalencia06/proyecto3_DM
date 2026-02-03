<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../vendor/autoload.php';
require_once '../Modelo/config_google.php';
require_once '../Modelo/user.php'; 
require_once '../Modelo/mailer.php';

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

    $google_oauth = new Google\Service\Oauth2($client); 
    $google_account_info = $google_oauth->userinfo->get();

    $google_id = $google_account_info->id;
    $email     = $google_account_info->email;
    $imagen    = $google_account_info->picture;

    $userModel = new user();
    $base_username = strstr($email, '@', true);
    $username_final = $base_username;

    if ($userModel->userExists($username_final)) {

        $username_final = $base_username . "_" . rand(100, 999);
        
    }
    
    $usuario_existente = $userModel->getUserByGoogleId($google_id);

    if ($usuario_existente) {
        $_SESSION['username']   = $usuario_existente['username']; 
        $_SESSION['fotografia'] = $usuario_existente['fotografia'];
        $_SESSION['email']      = $usuario_existente['email'];
        
    } else {

        if ($userModel->emailExists($email)) {
            $userModel->updateGoogleId($email, $google_id);
            $_SESSION['username']   = $username_final; 
            $_SESSION['fotografia'] = $imagen;
            $_SESSION['email']      = $email;

        } else {

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

            $mailer = new Mailer();
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