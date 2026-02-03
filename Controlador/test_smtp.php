<?php
// Controlador/test_smtp.php

// 1. Configuración básica para ver errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

// Intentamos cargar la configuración. 
// Si falla, el script se detendrá y sabremos que el error es que no encuentra el archivo.
if (!file_exists('../Modelo/config_mail.php')) {
    die("❌ ERROR CRÍTICO: No encuentro el archivo '../Modelo/config_mail.php'.");
}
require_once '../Modelo/config_mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<h1>🕵️ Diagnóstico de Correo (SMTP)</h1>";

// -----------------------------------------------------
// PARTE 1: VERIFICAR VARIABLES (Lo que lee Render)
// -----------------------------------------------------
echo "<h3>1. Verificando configuración...</h3>";

echo "<ul>";
echo "<li><b>HOST:</b> " . (defined('SMTP_HOST') ? SMTP_HOST : '❌ NO DEFINIDO') . "</li>";
echo "<li><b>USER:</b> " . (defined('SMTP_USER') ? SMTP_USER : '❌ NO DEFINIDO') . "</li>";
echo "<li><b>PORT:</b> 587 (Forzado manualmente)</li>";

// Verificamos la contraseña sin mostrarla entera
if (defined('SMTP_PASS') && !empty(SMTP_PASS)) {
    $pass = SMTP_PASS;
    $len = strlen($pass);
    $inicio = substr($pass, 0, 3);
    echo "<li><b>PASS:</b> ✅ Detectada ($len caracteres). Empieza por: <code>$inicio...</code></li>";
} else {
    echo "<li style='color:red'><b>PASS:</b> ❌ VACÍA O NO DEFINIDA. Revisa las variables de entorno en Render.</li>";
}
echo "</ul>";

// -----------------------------------------------------
// PARTE 2: INTENTO DE CONEXIÓN
// -----------------------------------------------------
echo "<h3>2. Intentando conectar con Brevo...</h3>";
echo "<div style='background: #f4f4f4; padding: 10px; border: 1px solid #ddd; font-family: monospace;'>";

$mail = new PHPMailer(true);

try {
    // Configuración de Debug (Muestra todo lo que pasa)
    $mail->SMTPDebug = 2; // 2 = Muestra mensajes de cliente y servidor
    $mail->Debugoutput = 'html'; // Formato HTML para que se lea bien en la web

    $mail->isSMTP();
    $mail->Host       = SMTP_HOST; 
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    
    // Configuración Blindada para Render
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587; 

    // Remitente y Destinatario (Prueba de auto-envío)
    $mail->setFrom(SMTP_FROM_EMAIL, 'Test Diagnostico');
    $mail->addAddress(SMTP_FROM_EMAIL, 'Yo Mismo'); 

    $mail->isHTML(true);
    $mail->Subject = 'Test de Diagnostico Render';
    $mail->Body    = 'Si ves esto, la conexión funciona.';

    // Intentamos enviar (el log saldrá en pantalla gracias a SMTPDebug)
    $mail->send();
    echo "</div>";
    echo "<h2 style='color:green'>✅ ¡ÉXITO! El correo ha salido del servidor.</h2>";

} catch (Exception $e) {
    echo "</div>"; // Cerramos la caja de logs
    echo "<h2 style='color:red'>❌ FALLO EN EL ENVÍO</h2>";
    echo "<p><b>Error reportado:</b> " . $mail->ErrorInfo . "</p>";
    
    // Pistas comunes según el error
    if (strpos($mail->ErrorInfo, 'connect to') !== false) {
        echo "<p>💡 <b>Pista:</b> Parece un bloqueo de puerto o firewall. ¿Seguro que es el puerto 587?</p>";
    }
    if (strpos($mail->ErrorInfo, 'Authentication failed') !== false) {
        echo "<p>💡 <b>Pista:</b> Tu usuario o contraseña están mal. Revisa la clave maestra en Brevo.</p>";
    }
    if (strpos($mail->ErrorInfo, 'Sender not allowed') !== false) {
        echo "<p>💡 <b>Pista:</b> El correo remitente no está autorizado en Brevo.</p>";
    }
}
?>