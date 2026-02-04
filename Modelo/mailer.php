<?php

require '../vendor/autoload.php'; 

if (file_exists(__DIR__ . '/config_mail.php')) {
    require_once __DIR__ . '/config_mail.php';
} else {
    die("Error: Falta el archivo de configuración (Modelo/config_mail.php)");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer {

    public function enviarBienvenida($destinatario, $nombreUsuario) {
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 0; 
            //$mail->Debugoutput = 'html';

            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER; 
            $mail->Password   = SMTP_PASS; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;
            
            $mail->CharSet = 'UTF-8';

            $mail->setFrom(SMTP_FROM_EMAIL, 'NomadNet');
            $mail->addAddress($destinatario, $nombreUsuario);

            $mail->isHTML(true);                           
            $mail->Subject = '¡Bienvenido a NomadNet!';
            
            $cuerpo = $cuerpo = <<<HTML
            <div style="font-family: Arial, sans-serif; color: #333; padding: 20px; max-width: 600px;">
                <h2 style="color: #2E8B57; border-bottom: 2px solid #2E8B57; padding-bottom: 10px;">
                    ¡Bienvenid@, $nombreUsuario!
                </h2>
                
                <p style="font-size: 16px; line-height: 1.5;">
                    Tu registro en <strong>NomadNet</strong> se ha completado correctamente.
                </p>
                
                <p style="font-size: 16px;">
                    Ya tienes tu cuenta activa. Gracias por unirte a nosotros.
                </p>
                
                <br>
                <p style="font-size: 14px; color: #666;">
                    Un saludo,<br>
                    <strong>El equipo de NomadNet</strong>
                </p>
            </div>
            HTML;
            
            $mail->Body    = $cuerpo;
            $mail->AltBody = "Bienvenido $nombreUsuario. Tu registro en NomadNet se ha completado correctamente.";

            $mail->send();
            return true; 

        } catch (Exception $e) { 
        }
    }
}
?>