<?php
// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: Login_P.php");
    exit();
}

// Obtener los datos del usuario desde la sesión
$id_usuario = $_SESSION['id'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone'];
$nombre = $_SESSION['username'];

// Verificar si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del formulario
    $servicio_nombre = $_POST['servicio'];  // Nombre del servicio principal
    $otros_servicios = isset($_POST['otros_servicios']) ? $_POST['otros_servicios'] : []; // Servicios adicionales
    $aclaracion = isset($_POST['aclaracion']) ? $_POST['aclaracion'] : '';

    // Conexión a la base de datos
    include "backend_DB.php";  // Verifica la ruta de este archivo

    // Obtener el ID del servicio principal a partir del nombre
    $sql_servicio = "SELECT id_servicio FROM Servicios WHERE nombre = ?";
    $stmt_servicio = $conn->prepare($sql_servicio);
    $stmt_servicio->bind_param("s", $servicio_nombre);  // Usamos "s" para string
    $stmt_servicio->execute();
    $result_servicio = $stmt_servicio->get_result();

    if ($result_servicio->num_rows > 0) {
        $servicio = $result_servicio->fetch_assoc();
        $servicio_id = $servicio['id_servicio'];  // Obtenemos el ID del servicio

        // Inserción del pedido principal (sin id_servicio, solo en Pedidos)
        $sql_pedido = "INSERT INTO Pedidos (id_usuario, descripcion, estado) VALUES (?, ?, 'pendiente')";
        $stmt_pedido = $conn->prepare($sql_pedido);
        $stmt_pedido->bind_param("is", $id_usuario, $aclaracion);

        if ($stmt_pedido->execute()) {
            $pedido_id = $stmt_pedido->insert_id;  // Obtener el ID del pedido recién insertado

            // Inserción del servicio principal en la tabla Pedido_Servicio
            $sql_pedido_servicio = "INSERT INTO Pedido_Servicio (id_pedido, id_servicio) VALUES (?, ?)";
            $stmt_servicio_pedido = $conn->prepare($sql_pedido_servicio);
            $stmt_servicio_pedido->bind_param("ii", $pedido_id, $servicio_id);
            $stmt_servicio_pedido->execute();  // Inserta el servicio principal

            // Obtener los nombres de los servicios adicionales
            $nombres_servicios_adicionales = []; // Array para almacenar los nombres de los servicios adicionales
            if (!empty($otros_servicios)) {
                $sql_servicios_adicionales = "SELECT nombre FROM Servicios WHERE id_servicio = ?";
                $stmt_servicios = $conn->prepare($sql_servicios_adicionales);
                foreach ($otros_servicios as $servicio_extra) {
                    // Obtener el nombre del servicio adicional
                    $stmt_servicios->bind_param("i", $servicio_extra);
                    $stmt_servicios->execute();
                    $resultado_servicio_extra = $stmt_servicios->get_result();
                    if ($resultado_servicio_extra->num_rows > 0) {
                        $servicio_extra_nombre = $resultado_servicio_extra->fetch_assoc();
                        $nombres_servicios_adicionales[] = $servicio_extra_nombre['nombre'];
                    }
                    
                    // Insertar el servicio adicional en Pedido_Servicio
                    $sql_insert_pedido_servicio = "INSERT INTO Pedido_Servicio (id_pedido, id_servicio) VALUES (?, ?)";
                    $stmt_insert_servicio = $conn->prepare($sql_insert_pedido_servicio);
                    $stmt_insert_servicio->bind_param("ii", $pedido_id, $servicio_extra);
                    $stmt_insert_servicio->execute();
                }
                $stmt_servicios->close();
            }

            // Configuración de PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cerrajeriaaranguren4@gmail.com';
            $mail->Password = 'zbmkzdusgifbjxea';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('cerrajeriaaranguren4@gmail.com', 'Administrador');
            $mail->addAddress('cerrajeriaaranguren4@gmail.com', 'Admin');

            // Preparar el contenido del correo
            $servicios_adicionales_texto = !empty($nombres_servicios_adicionales) ? implode(', ', $nombres_servicios_adicionales) : 'Ninguno';

            $mail->Subject = 'Nuevo Pedido Recibido';
            $mail->Body = "Nuevo pedido recibido. Detalles del pedido:\n\n"
                          . "ID del Pedido: $pedido_id\n"
                          . "Cliente: $nombre ($email)\n"
                          . "Descripción: $aclaracion\n"
                          . "Servicios: $servicio_nombre\n"
                          . "Servicios adicionales: $servicios_adicionales_texto";

            // Enviar correo
            if (!$mail->send()) {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            }

            // Confirmación de éxito y redirección al usuario
            header("Location: confirmarPedido.php");
            exit();

        } else {
            // Error al insertar el pedido
            echo "Error al realizar el pedido: " . $stmt_pedido->error;
        }

        $stmt_pedido->close();
    } else {
        echo "Servicio no encontrado.";
    }

    $stmt_servicio->close();
    $conn->close();
} else {
    echo "No se han recibido datos del formulario.";
}
?>
