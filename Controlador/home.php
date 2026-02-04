<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../Modelo/user.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); 
    exit();
}

    include "../Vista/home.php";