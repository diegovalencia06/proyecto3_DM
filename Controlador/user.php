<?php
// Controlador/perfil.php

session_start();
require_once "../Modelo/user.php";

// 1. SEGURIDAD: Verificar si el usuario está logueado
if (!isset($_SESSION['username'])) {
    // Si no hay sesión, mandamos al login
    header("Location: ../Controlador/login.php"); 
    exit();
}

// 2. OBTENER DATOS: Pedimos al Modelo la info fresca de la BD
$userModel = new user();
$datosUsuario = $userModel->getUserByUsername($_SESSION['username']);

// 3. VALIDACIÓN: ¿Existe el usuario? (Por si se borró la cuenta mientras estaba logueado)
if (!$datosUsuario) {
    session_destroy();
    header("Location: ../Vista/login.php");
    exit();
}

// 4. LÓGICA DE VISUALIZACIÓN: Preparar la foto
// Si tiene foto la usamos, si no, ponemos una por defecto
$foto_perfil = !empty($datosUsuario['fotografia']) 
    ? $datosUsuario['fotografia'] 
    : "https://via.placeholder.com/150?text=Usuario";

// 5. CARGAR LA VISTA: Le pasamos el control al HTML
// Las variables $datosUsuario y $foto_perfil estarán disponibles en la vista automáticamente
require_once "../Vista/user.php";
?>