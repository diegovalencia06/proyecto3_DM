<?php

// 1. Cargar secretos locales si existen (Tu PC)
$archivo_secretos = __DIR__ . '/secret.php';
if (file_exists($archivo_secretos)) {
    include_once $archivo_secretos;
}

define('GOOGLE_CLIENT_ID', 
    defined('LOCAL_GOOGLE_ID') ? LOCAL_GOOGLE_ID : getenv('GOOGLE_CLIENT_ID')
);

define('GOOGLE_CLIENT_SECRET', 
    defined('LOCAL_GOOGLE_SECRET') ? LOCAL_GOOGLE_SECRET : getenv('GOOGLE_CLIENT_SECRET')
);

define('GOOGLE_REDIRECT_URL', 
    defined('LOCAL_GOOGLE_URL') ? LOCAL_GOOGLE_URL : getenv('GOOGLE_REDIRECT_URL')
);

?>