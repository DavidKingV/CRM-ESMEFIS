<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__.'/../models/ApiModel.php';

use Vendor\Esmefis\DBConnection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSender {
    public static function sendEmail($data) {
        // Instancia de Twig
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('event.html')->render($data); // Renderizar el template con Twig

        $mail = new PHPMailer(true);

        try {
            //Configuración del servidor SMTP
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->Debugoutput = 'html';
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host       = 'mail.unif.clinic';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'edson.m@unif.clinic';
            $mail->Password   = '[]5~E$f[6=IE';
            $mail->SMTPSecure = 'TLS';            //Enable implicit TLS encryption
            $mail->Port       = 587; 

            // Remitente y destinatario
            $mail->setFrom('edson.m@unif.clinic', $data['name']);
            $mail->addAddress($data['email'], $data['name']);
        
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Gracias por tu interes en nuestros programas';
            $mail->Body = $template;  // Insertar el template procesado con Twig
            $mail->AltBody = strip_tags($template); // Texto alternativo sin HTML
        
            // Enviar el correo
            $mail->send();
            return [
                'success' => true,
                'message' => 'Correo enviado correctamente'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al enviar el correo, por favor intente de nuevo más tarde'
            ];
        }
    }


}