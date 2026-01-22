<?php

function connection() {
   
    mysqli_report(MYSQLI_REPORT_OFF);

    $host = getenv('DB_HOST');
    $user = getenv('DB_USERNAME');
    $pass = getenv('DB_PASSWORD');
    $db   = getenv('DB_NAME');
    $port = getenv('DB_PORT');

    $mysqli_conexion = mysqli_init();
    $mysqli_conexion->ssl_set(NULL, NULL, NULL, NULL, NULL);
    
    @$mysqli_conexion->real_connect($host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);

    if ($mysqli_conexion->connect_errno) {

        echo "Error de conexión: " . $mysqli_conexion->connect_errno;

    } else {

        echo "Hemos podido conectarnos con MySQL";

    }

    return $mysqli_conexion;
}
?>