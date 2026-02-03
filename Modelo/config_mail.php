<?php

$archivo_secretos = __DIR__ . '/secret.php';

if (file_exists($archivo_secretos)) {
    include_once $archivo_secretos;
}

define('SMTP_HOST', 'smtp-relay.brevo.com'); 
define('SMTP_USER', defined('LOCAL_SMTP_USER') ? LOCAL_SMTP_USER : getenv('SMTP_USER'));

define('SMTP_PASS', defined('LOCAL_SMTP_PASS') ? LOCAL_SMTP_PASS : getenv('SMTP_PASS'));

define('SMTP_FROM_EMAIL', 'diegomonreal06@gmail.com');

?>