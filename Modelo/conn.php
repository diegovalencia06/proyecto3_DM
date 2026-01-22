<?php

function connection() {
    // FUNCIÓN AUXILIAR PARA BUSCAR VARIABLES
    // Busca en $_ENV, luego en $_SERVER, luego en getenv()
    function getVar($key) {
        if (isset($_ENV[$key])) return $_ENV[$key];
        if (isset($_SERVER[$key])) return $_SERVER[$key];
        return getenv($key);
    }

    // 1. OBTENER VARIABLES
    $host = getVar('DB_HOST');
    $user = getVar('DB_USERNAME'); // Aquí es donde estaba fallando
    $pass = getVar('DB_PASSWORD');
    $db   = getVar('DB_NAME');
    $port = getVar('DB_PORT');

    // 2. DEPURACIÓN (Si falla, esto nos dirá qué variable falta)
    // Esto matará la página y mostrará el error en pantalla si falta algo.
    if (empty($host) || empty($user) || empty($pass)) {
        die("ERROR CRÍTICO: Variables de entorno vacías. <br>" .
            "Host: " . ($host ? 'OK' : 'VACÍO') . "<br>" .
            "User: " . ($user ? 'OK' : 'VACÍO') . "<br>" .
            "Pass: " . ($pass ? 'OK' : 'VACÍO'));
    }

    // 3. INICIALIZAR MYSQLI
    $mysqli = mysqli_init();
    if (!$mysqli) die("Falló mysqli_init");

    // 4. CONFIGURAR SSL (Necesario para TiDB)
    $mysqli->ssl_set(NULL, NULL, NULL, NULL, NULL);

    // 5. CONECTAR
    // Usamos @ para suprimir el error fatal de PHP y manejarlo nosotros con el 'die' de abajo
    $conectado = @$mysqli->real_connect($host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);

    if (!$conectado) {
        die("Error de conexión a TiDB: " . mysqli_connect_error() . 
            "<br>Código de error: " . mysqli_connect_errno());
    }

    return $mysqli;
}
?>