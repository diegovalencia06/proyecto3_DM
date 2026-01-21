<?php

function connection() {

    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');
    $db   = getenv('DB_NAME');
    $port = getenv('DB_PORT');

    $mysqli = mysqli_init();

    if (!$mysqli) {
        die("Falló mysqli_init");
    }

    $mysqli->ssl_set(NULL, NULL, NULL, NULL, NULL);

    $conectado = $mysqli->real_connect($host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);

    if (!$conectado) {

        die("Error de conexión ('Connect Error'): " . mysqli_connect_error());
    
    } else {

        echo "La conexión es segura";

    }

    return $mysqli;
}
?>