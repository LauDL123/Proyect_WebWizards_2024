<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Verificar que el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../index.php");
    exit();
}

include "../Backend/backend_DB.php";

function actualizar_estado_pedido($id_pedido, $estado) {
    global $conn;
    $sql = "UPDATE Pedidos SET estado = ? WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $estado, $id_pedido);
    return $stmt->execute();
}

if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];

    // Actualizar el estado del pedido a "Finalizado" (estado = 3)
    if (actualizar_estado_pedido($id_pedido, 3)) {
        // Enviar un correo al cliente notificando que su pedido ha sido finalizado
        $sql_cliente = "SELECT nombre_cliente, email_cliente FROM Pedidos WHERE id_pedido = ?";
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("i", $id_pedido);
        $stmt_cliente->execute();
        $resultado = $stmt_cliente->get_result();
        
        if ($resultado->num_rows > 0) {
            $cliente = $resultado->fetch_assoc();
            $nombre_cliente = $cliente['nombre_cliente'];
            $email_cliente = $cliente['email_cliente'];

            // Configurar PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cerrajeriaaranguren4@gmail.com';
                $mail->Password = 'zbmkzdusgifbjxea';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('tu_correo@gmail.com', 'Administrador');
                $mail->addAddress($email_cliente, $nombre_cliente);
                $mail->isHTML(true);
                $mail->Subject = 'Pedido Finalizado';
                $mail->Body    = "<h2>Estimado $nombre_cliente,</h2><p>Su pedido ha sido finalizado. ¡Gracias por su preferencia!</p>";
                $mail->send();
                echo '<script>alert("Pedido finalizado con éxito y correo enviado al cliente."); window.location.href = "../gestionar_pedidos.php";</script>';
            } catch (Exception $e) {
                echo '<script>alert("Hubo un error al enviar el correo: ' . $mail->ErrorInfo . '"); window.location.href = "../gestionar_pedidos.php";</script>';
            }
        }
    } else {
        echo '<script>alert("Error al actualizar el estado del pedido."); window.location.href = "../gestionar_pedidos.php";</script>';
    }
}
?>
