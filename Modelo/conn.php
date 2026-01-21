<?php 

function connection() {

    $conn = new mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'), getenv('DB_PORT'));

    if($conn->connect_errno) {

        echo "Error de conexión: " . $conn->connect_errno;

    } else {

        echo "Conexión correcta";

    }

}