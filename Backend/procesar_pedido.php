<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include "backend_DB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servicio = $_POST['servicio'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $aclaracion = $_POST['aclaracion'];

    // Insertar el pedido en la base de datos
    $sql = "INSERT INTO Pedidos (id_cliente, servicio, aclaracion, estado) VALUES (?, ?, ?, 'Pendiente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $_SESSION['id'], $servicio, $aclaracion);
    $stmt->execute();

    // Enviar el correo al administrador
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cerrajeriaaranguren4@gmail.com';  // correo
        $mail->Password = 'zbmkzdusgifbjxea';  //contraseña de aplicación de Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, $nombre);
        $mail->addAddress('cerrajeriaaranguren4@gmail.com', 'Administrador');

        $mail->isHTML(true);
        $mail->Subject = "Nuevo Pedido de Servicio: $servicio";
        $mail->Body = "
            <h2>Nuevo pedido de servicio</h2>
            <p><strong>Nombre:</strong> $nombre</p>
            <p><strong>Correo Electrónico:</strong> $email</p>
            <p><strong>Teléfono:</strong> $telefono</p>
            <p><strong>Servicio seleccionado:</strong> $servicio</p>
            <p><strong>Aclaración:</strong> $aclaracion</p>";

        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>
