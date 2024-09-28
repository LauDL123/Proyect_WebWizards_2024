<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Primero tomar los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$numero = $_POST['numero'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];
//configurar el correo electronico
$mail = new PHPMailer(true);
}

try{
//configuracion del servidor gmail
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';// Servidor SMPT que usa gmail.
$mail->SMTPAuth = true;
$mail->Username = 'petisolombardo444@gmail.com';
$mail->Password = 'dktgvxwwsyylbziy';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

//Correo del usuario que relleno el formulario
$mail->setFrom($email, $nombre);

//Destinatario: el admin
$mail->addAddress('petisolombardo444@gmail.com', 'Administrador');

//contenido del correo enviado
$mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = "
        <h2>Nuevo mensaje de: $nombre</h2>
        <p><strong>Correo Electrónico:</strong> $email</p>
        <p><strong>Número de Teléfono:</strong> $numero</p>
        <p><strong>Mensaje:</strong></p>
        <p>$mensaje</p>";
        
        // Enviar correo
        $mail->send();
        echo '<script type="text/javascript">
                alert("Correo enviado con exito");
                window.location.href = "../Body/mensaje.php";
              </script>';

    } catch (Exception $e) {
        echo '<script type="text/javascript">
                alert ("Hubo un error al enviar el mensaje: {$mail->ErrorInfo}");
                window.location.href = "../Body/mensaje.php";
              </script>';
    }
