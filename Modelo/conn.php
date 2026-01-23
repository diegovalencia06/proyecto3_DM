<?php

function connection() {
    mysqli_report(MYSQLI_REPORT_OFF);

    $host = 'gateway01.eu-central-1.prod.aws.tidbcloud.com';
    $port = 4000;
    $user = '3JhW99ENnhMHVWY.root'; 
    $pass = 'XX2bk3MYnACr020B';      
    $db   = 'test';

    $mysqli_conexion = mysqli_init();
    $mysqli_conexion->ssl_set(NULL, NULL, NULL, NULL, NULL);
    
    @$mysqli_conexion->real_connect($host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);

    if ($mysqli_conexion->connect_errno) {
        echo "Error de conexión: " . $mysqli_conexion->connect_errno;
        exit(); 
    }

    return $mysqli_conexion;
}
?>