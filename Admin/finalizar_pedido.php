<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../Backend/backend_DB.php';

// Incluir las bibliotecas necesarias
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// Obtener el ID del pedido desde el parámetro GET
$id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : null;

// Verificar si se obtuvo el ID del pedido
if (!$id_pedido) {
    echo "ID de pedido no válido.";
    exit;
}

// Obtener los datos del pedido
$sql = "SELECT p.*, u.email FROM Pedidos p JOIN usuarios u ON p.id_usuario = u.id_usuario WHERE p.id_pedido = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Error al preparar la consulta
    echo "Error al preparar la consulta: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$resultado = $stmt->get_result();
$pedido = $resultado->fetch_assoc();

if (!$pedido) {
    echo "Pedido no encontrado.";
    exit;
}

// Obtener los servicios asociados al pedido
$sql_servicios = "SELECT s.nombre_servicio FROM Pedido_Servicio ps JOIN Servicios s ON ps.id_servicio = s.id_servicio WHERE ps.id_pedido = ?";
$stmt_servicios = $conn->prepare($sql_servicios);

if ($stmt_servicios === false) {
    // Error al preparar la consulta
    echo "Error al preparar la consulta de servicios: " . $conn->error;
    exit;
}

$stmt_servicios->bind_param("i", $id_pedido);
$stmt_servicios->execute();
$resultado_servicios = $stmt_servicios->get_result();

$servicios = [];
while ($servicio = $resultado_servicios->fetch_assoc()) {
    $servicios[] = $servicio['nombre_servicio'];
}

// Enviar correo de notificación de finalización
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = 'cerrajeriaaranguren4@gmail.com';  // correo
    $mail->Password = 'zbmkzdusgifbjxea';  //contraseña de aplicación de Google
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Destinatario
    $mail->setFrom('cerrajeriaaranguren4@gmail.com', 'Cerrjaeria Aranguren');
    $mail->addAddress($pedido['email'], 'Cliente');  // Correo del cliente

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Tu pedido ha sido finalizado';
    $mail->Body = 'Hola, <br>Tu pedido ha sido finalizado. Los servicios que elegiste son: <br>' . implode('<br>', $servicios);

    $mail->send();
} catch (Exception $e) {
    echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
    exit;  // En caso de que no se pueda enviar el correo, detenemos la ejecución.
}

// Actualizar el estado del pedido en la base de datos
$sql_update = "UPDATE Pedidos SET estado = 'Finalizado' WHERE id_pedido = ?";
$stmt_update = $conn->prepare($sql_update);

if ($stmt_update === false) {
    // Error al preparar la consulta de actualización
    echo "Error al preparar la consulta de actualización: " . $conn->error;
    exit;
}

$stmt_update->bind_param("i", $id_pedido);
$stmt_update->execute();

// Crear el recibo en PDF
require_once('../vendor/fpdf/src/fpdf.php');  

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Recibo de Pedido Finalizado');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Pedido ID: ' . $pedido['id_pedido']);
$pdf->Ln(10);
$pdf->Cell(40, 10, 'Cliente: ' . $pedido['id_usuario']);
$pdf->Ln(10);
$pdf->Cell(40, 10, 'Servicios seleccionados:');
foreach ($servicios as $servicio) {
    $pdf->Ln(10);
    $pdf->Cell(40, 10, $servicio);
}
$pdf->Ln(10);
$pdf->Cell(40, 10, 'Gracias por tu compra!');

// Guardar el PDF en el servidor
$pdf_output = '../recibos/recibo_' . $id_pedido . '.pdf';  // Asegúrate de que la carpeta exista
$pdf->Output('F', $pdf_output);

// Enviar enlace al cliente con el recibo
$mail->clearAddresses();
$mail->addAddress($pedido['email'], 'Cliente');
$mail->Subject = 'Tu recibo de compra';
$mail->Body = 'Hola, <br>Tu recibo está disponible en el siguiente enlace: <a href="http://webwizrds/recibos/' . basename($pdf_output) . '">Descargar Recibo</a>';
$mail->send();

echo "Pedido finalizado y correo enviado.";
?>
