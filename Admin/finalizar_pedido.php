<?php

// Mostrar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../Backend/backend_DB.php';

// Incluir las bibliotecas necesarias para enviar correos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// Verificar si el parámetro 'id' del pedido ha sido especificado
if (isset($_GET['id'])) {
    $id_pedido = intval($_GET['id']);

    // Obtener información del pedido
    $consulta_pedido = "SELECT p.*, u.email, u.username FROM Pedidos p
                        JOIN usuarios u ON p.id_usuario = u.id
                        WHERE p.id_pedido = ?";
    $stmt = $conn->prepare($consulta_pedido);
    $stmt->bind_param("i", $id_pedido);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $pedido = $resultado->fetch_assoc();

            // Cambiar el estado del pedido a "finalizado"
            $actualizar_pedido = "UPDATE Pedidos SET estado = 'finalizado' WHERE id_pedido = ?";
            $stmt_actualizar = $conn->prepare($actualizar_pedido);
            $stmt_actualizar->bind_param("i", $id_pedido);
            $stmt_actualizar->execute();

            // Enviar un correo electrónico al cliente
            $email_cliente = $pedido['email'];
            $nombre_cliente = $pedido['username'];

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor de correo
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cerrajeriaaranguren4@gmail.com'; 
                $mail->Password = 'zbmkzdusgifbjxea'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configuración del correo
                $mail->setFrom('cerrajeriaaranguren4@gmail.com', 'Cerrajeria Aranguren');
                $mail->addAddress($email_cliente, $nombre_cliente);
                $mail->isHTML(true);
                $mail->Subject = "Pedido Finalizado";
                $mail->Body = "Estimado $nombre_cliente,<br>Su pedido #$id_pedido ha sido finalizado. ¡Gracias por confiar en nosotros!";

                $mail->send();
                echo "El pedido ha sido finalizado y el correo ha sido enviado.";
            } catch (Exception $e) {
                echo "El pedido ha sido finalizado, pero hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            echo "No se encontró un pedido con el ID especificado.";
        }
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();

} else {
    echo "No se ha especificado ningún ID de pedido.";
}

?>
