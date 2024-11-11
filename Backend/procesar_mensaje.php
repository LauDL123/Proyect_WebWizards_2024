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

    // Configurar el correo electrónico
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Servidor SMTP que usa Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'cerrajeriaaranguren4@gmail.com';  // correo
        $mail->Password = 'zbmkzdusgifbjxea';  //contraseña de aplicación de Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Correo del usuario que rellenó el formulario
        $mail->setFrom($email, $nombre);

        // Destinatario: el admin
        $mail->addAddress('cerrajeriaaranguren4@gmail.com', 'Administrador');

        // Contenido del correo enviado
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = "
        <h2>Nuevo mensaje de: $nombre</h2>
        <p><strong>Correo Electrónico:</strong> $email</p>
        <p><strong>Número de Teléfono:</strong> $numero</p>
        <p><strong>Mensaje:</strong></p>
        <p>$mensaje</p>";

        // Enviar correo
        if ($mail->send()) {
            echo '<script type="text/javascript">
                    alert("Correo enviado con éxito");
                    window.location.href = "../mensaje.php";
                  </script>';
        } else {
            throw new Exception('Error al enviar el correo');
        }

    } catch (Exception $e) {
        // Mostrar mensaje de error
        echo '<script type="text/javascript">
                alert("Hubo un error al enviar el mensaje: ' . $mail->ErrorInfo . '");
                window.location.href = "../mensaje.php";
              </script>';
    }
}
?>
