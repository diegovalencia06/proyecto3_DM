<?php
// Controlador/test_smtp.php

// Forzamos salida inmediata para ver el progreso y evitar pantalla blanca
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('output_buffering', 'off');
ini_set('zlib.output_compression', false);
while (@ob_end_flush());
ini_set('implicit_flush', true);
ob_implicit_flush(true);

echo "<h1>🕵️ Diagnóstico SMTP (Versión Corregida)</h1>";

require_once '../vendor/autoload.php';

if (!file_exists('../Modelo/config_mail.php')) {
    die("❌ Error: No encuentro config_mail.php");
}
require_once '../Modelo/config_mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<p>✅ Librerías cargadas. Iniciando...</p>";
flush(); 

$mail = new PHPMailer(true);

try {
    // DEBUG NIVEL MÁXIMO
    $mail->SMTPDebug = 2; 
    $mail->Debugoutput = function($str, $level) {
        echo "<div style='font-size:12px; color:#555; border-bottom:1px solid #eee;'>Debug: $str</div>";
        flush(); 
    };

    $mail->isSMTP();
    
    // --- CONFIGURACIÓN CRÍTICA ---
    $mail->Timeout  = 8; // Esperamos máximo 8 segundos. Si tarda más, cortamos.
    
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587; 

    // Remitente y Destinatario
    $mail->setFrom(SMTP_FROM_EMAIL, 'Test Render');
    $mail->addAddress(SMTP_FROM_EMAIL, 'Yo Mismo'); 

    $mail->Subject = 'Test Final';
    $mail->Body    = 'Si lees esto, funciona.';

    echo "<p>⏳ Conectando a Brevo por puerto 587...</p>";
    flush();

    $mail->send();
    echo "<h2 style='color:green'>✅ ¡ENVIADO CON ÉXITO!</h2>";

} catch (Exception $e) {
    echo "<h2 style='color:red'>❌ ERROR DE ENVÍO:</h2>";
    echo "<b>Mensaje:</b> " . $e->getMessage() . "<br>";
    echo "<b>Log técnico:</b> " . $mail->ErrorInfo;
}
?>