<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../Backend/backend_DB.php';
require_once '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/fpdf/fpdf/src/Fpdf/Fpdf.php';;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'], $_POST['precios'])) {
    echo "Formulario recibido. Procesando...<br>";
    $id_pedido = intval($_POST['id_pedido']);
    $precios = array_map(function($precio) {
        return is_numeric($precio) ? floatval($precio) : 0;
    }, $_POST['precios']);
    
    try {
        // Consulta para obtener los detalles del pedido
        $query = "
        SELECT p.id_pedido, p.descripcion, p.estado, u.username, u.email, u.address, u.phone
        FROM Pedidos p
        JOIN usuarios u ON p.id_usuario = u.id
        LEFT JOIN Clientes c ON u.id = c.id_usuario
        WHERE p.id_pedido = ?";

        // Preparar la consulta
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Ejecutar la consulta
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $retval = $stmt->get_result();

        // Verificar si la consulta devolvió resultados
        if ($retval->num_rows === 0) {
            die("No se encontraron resultados para el pedido con ID: $id_pedido");
        }

        $pedido = $retval->fetch_assoc();
        echo "Datos del pedido obtenidos: ";
        print_r($pedido); // Depuración

        // Obtener los servicios del pedido
        $query_servicios = "
            SELECT s.id_servicio, s.nombre  -- Cambié 's.id' por 's.id_servicio'
            FROM Pedido_Servicio ps
            JOIN Servicios s ON ps.id_servicio = s.id_servicio  -- También corregí aquí
            WHERE ps.id_pedido = ?";
        $stmt_servicios = $conn->prepare($query_servicios);
        if ($stmt_servicios === false) {
            die("Error al preparar la consulta de servicios: " . $conn->error);
        }
        
        // Ejecutar la consulta de servicios
        $stmt_servicios->bind_param("i", $id_pedido);
        $stmt_servicios->execute();
        $resultado_servicios = $stmt_servicios->get_result();

        // Procesar los servicios
        $servicios = [];
        $total = 0;
        while ($row = $resultado_servicios->fetch_assoc()) {
            $servicios[] = $row;
        }

        // Cambiar estado del pedido
        echo "Actualizando estado del pedido...<br>";
        $actualizar_pedido = "UPDATE Pedidos SET estado = 'finalizado' WHERE id_pedido = ?";
        $stmt_actualizar = $conn->prepare($actualizar_pedido);
        if ($stmt_actualizar === false) {
            die("Error al preparar la consulta de actualización: " . $conn->error);
        }
        
        // Ejecutar la actualización
        $stmt_actualizar->bind_param("i", $id_pedido);
        $stmt_actualizar->execute();
        echo "Estado del pedido actualizado.<br>";

        
// Crear PDF de la factura
echo "Generando PDF de la factura...<br>";

$pdf = new \Fpdf\Fpdf();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Factura', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln();

$pdf->Cell(0, 10, "Pedido ID: $id_pedido", 0, 1);
$pdf->Cell(0, 10, "Cliente: " . $pedido['username'], 0, 1);
$pdf->Cell(0, 10, "Correo: " . $pedido['email'], 0, 1);
$pdf->Cell(0, 10, "Direccion: " . (isset($pedido['address']) ? $pedido['address'] : 'No disponible'), 0, 1);
$pdf->Cell(0, 10, "Telefono: " . (isset($pedido['phone']) ? $pedido['phone'] : 'No disponible'), 0, 1);

$pdf->Ln();

// Mostrar servicios, cantidades y precios
$pdf->Cell(40, 10, "Cantidad", 1, 0, 'C');
$pdf->Cell(100, 10, "Servicio", 1, 0, 'C');
$pdf->Cell(40, 10, "Precio", 1, 1, 'C');

// Inicializamos el total
$total = 0;

foreach ($servicios as $servicio) {
    $id_servicio = $servicio['id_servicio'];

    if (isset($precios[$id_servicio]) && is_numeric($precios[$id_servicio])) {
        $precio = $precios[$id_servicio];

        // Obtener la cantidad desde el formulario
        $cantidad = isset($_POST['cantidades'][$id_servicio]) ? $_POST['cantidades'][$id_servicio] : 0;
        
        // Asegurarse de que la cantidad es válida
        if ($cantidad > 0) {
            // Mostrar la cantidad, nombre del servicio y el precio
            $pdf->Cell(40, 10, $cantidad, 1, 0, 'C'); // Celda para la cantidad
            $pdf->Cell(100, 10, $servicio['nombre'], 1);
            $pdf->Cell(40, 10, "$" . number_format($precio, 2), 1, 1, 'C');

            // Sumar el precio al total
            $total += $precio;
        }
    }
}

// Mostrar el total
$pdf->Ln();
$pdf->Cell(100, 10, "Total", 1, 0, 'C');
$pdf->Cell(40, 10, "$" . number_format($total, 2), 1, 1, 'C');
$pdf->Ln();

// Fecha
$fecha_actual = date("d/m/Y");
$pdf->Cell(0, 10, "Fecha: $fecha_actual", 0, 1);

// Mensaje de agradecimiento
$pdf->Ln(10); // Espacio antes del mensaje
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Gracias por preferir Cerrajeria Aranguren", 0, 1, 'C');

        // Guardar el archivo PDF
        if (!is_dir('../facturas')) mkdir('../facturas', 0777, true);
        $archivoPDF = "../facturas/factura_$id_pedido.pdf";
        $pdf->Output('F', $archivoPDF);
        if (file_exists($archivoPDF)) {
            echo "PDF generado en: $archivoPDF<br>";
        } else {
            echo "Error al generar el PDF.<br>";
        }

        // Enviar correo
        echo "Preparando para enviar correo...<br>";
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cerrajeriaaranguren4@gmail.com';
        $mail->Password = 'zbmkzdusgifbjxea';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('cerrajeriaaranguren4@gmail.com', 'Cerrajeria Aranguren');
        $mail->addAddress($pedido['email'], $pedido['username']);
        $mail->addAttachment($archivoPDF);
        $mail->isHTML(true);
        $mail->Subject = "Factura de Pedido $id_pedido";
        $mail->Body    = "<h1>Factura de Pedido $id_pedido</h1><p>Adjunto encontrarás la factura de tu pedido. Debe de presentarla en el local para pagar su pedido.</p>";

        $mail->send();
        echo 'Correo enviado exitosamente.<br>';

        // Mostrar mensaje de éxito
        echo "<script>alert('Pedido finalizado y correo enviado.'); window.location.href = 'pedidos.php';</script>";
    } catch (Exception $e) {
        echo "Error en el proceso: " . $e->getMessage() . "<br>";
    }
}
?>
