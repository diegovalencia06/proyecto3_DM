<?php
// Controlador/update_profile.php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once '../Modelo/user.php';

// Cargar configuración de Cloudinary si existe
if (file_exists('../Modelo/config_cloud.php')) {
    require_once '../Modelo/config_cloud.php';
}

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

// 1. SEGURIDAD: Solo usuarios logueados
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Vista/login.php");
    exit();
}

// 2. PROCESAR EL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_usuario = $_SESSION['user_id']; // Usamos el ID de la sesión por seguridad
    $username   = trim($_POST['username']);
    $telefono   = trim($_POST['telefono']);
    $fecha      = $_POST['date']; // Asegúrate que el input se llama 'date'

    // --- LOGICA CLOUDINARY ---
    $url_nueva_foto = null;

    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
        if (defined('CLOUDINARY_URL')) {
            try {
                Configuration::instance(CLOUDINARY_URL);
                $upload = new UploadApi();
                $resultado = $upload->upload($_FILES['fotografia']['tmp_name'], [
                    'folder' => 'usuarios_nomadnet',
                    'public_id' => 'user_' . uniqid(),
                    'resource_type' => 'image'
                ]);
                $url_nueva_foto = $resultado['secure_url'];
            } catch (Exception $e) {
                // Si falla la subida, continuamos pero sin actualizar foto
                error_log("Error Cloudinary: " . $e->getMessage());
            }
        }
    }

    // --- GUARDAR EN BD ---
    $userModel = new user();
    
    $datos = [
        'username'   => $username,
        'telefono'   => $telefono,
        'date'       => $fecha,
        'fotografia' => $url_nueva_foto // Si es null, el modelo sabrá qué hacer
    ];

    if ($userModel->updateUser($id_usuario, $datos)) {
        
        // ¡IMPORTANTE! ACTUALIZAR LA SESIÓN
        // Para que el usuario vea los cambios sin tener que volver a loguearse
        $_SESSION['username'] = $username;
        if ($url_nueva_foto) {
            $_SESSION['fotografia'] = $url_nueva_foto;
        }

        // Redirigir al perfil
        header("Location: ../Vista/perfil.php?status=success");
        exit();

    } else {
        echo "Error al actualizar la base de datos.";
    }

} else {
    // Si intentan entrar directo sin POST
    header("Location: ../Vista/perfil.php");
    exit();
}
?>