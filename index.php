<?php 

if (!isset($_SESSION['username'])) {
    header("Location: ./Controlador/login.php");
    exit();
}

header("Location: ./Controlador/home.php");