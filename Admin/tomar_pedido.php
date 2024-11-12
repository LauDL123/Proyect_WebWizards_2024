<?php
// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);
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

// Función para actualizar el estado del pedido
function actualizar_estado_pedido($id_pedido, $estado) {
    global $conn;
    $sql = "UPDATE Pedidos SET estado = ? WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estado, $id_pedido);  // Usar 's' para la cadena en lugar de 'i'
    return $stmt->execute();
}

// Verificar si se ha recibido el id del pedido
if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];

    // Actualizar el estado del pedido a "Tomado"
    if (actualizar_estado_pedido($id_pedido, 'tomado')) {
        // Obtener los datos del cliente (nombre y email) de la tabla 'Usuarios' mediante el id_usuario de 'Pedidos'
        $sql_cliente = "
        SELECT u.username, u.email 
        FROM Pedidos p
        INNER JOIN usuarios u ON p.id_usuario = u.id
        WHERE p.id_pedido = ?
    ";
    
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("i", $id_pedido);
        $stmt_cliente->execute();
        $resultado = $stmt_cliente->get_result();
        
        if ($resultado->num_rows > 0) {
            $cliente = $resultado->fetch_assoc();
            $nombre_cliente = $cliente['username'];  // Usamos 'username' según la base de datos
            $email_cliente = $cliente['email'];

            // Configurar PHPMailer para enviar el correo
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cerrajeriaaranguren4@gmail.com'; // Asegúrate de utilizar una cuenta válida
                $mail->Password = 'zbmkzdusgifbjxea'; // Asegúrate de utilizar una contraseña válida
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('cerrajeriaaranguren4@gmail.com', 'Administrador');
                $mail->addAddress($email_cliente, $nombre_cliente);
                $mail->isHTML(true);
                $mail->Subject = 'Pedido Tomado';
                $mail->Body    = "<h2>Estimado $nombre_cliente,</h2><p>Su pedido ha sido tomado y está en proceso.</p>";
                $mail->send();
                header("Location: pedidos.php?mensaje=Pedido tomado con éxito y correo enviado al cliente.");
                exit();
            } catch (Exception $e) {
                echo '<script>alert("Hubo un error al enviar el correo: ' . $mail->ErrorInfo . '"); window.location.href = "pedidos.php";</script>';
            }
        } else {
            echo '<script>alert("No se pudo encontrar el cliente asociado al pedido."); window.location.href = "pedidos.php";</script>';
        }
    } else {
        echo '<script>alert("Error al actualizar el estado del pedido."); window.location.href = "pedidos.php";</script>';
    }
}
?>
