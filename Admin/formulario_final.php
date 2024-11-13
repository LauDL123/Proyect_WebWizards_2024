<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../Backend/backend_DB.php';

// Obtener el ID del pedido
$id_pedido = isset($_GET['id']) ? $_GET['id'] : null;

// Validar que el ID del pedido esté presente
if (!$id_pedido) {
    die("ID de pedido no proporcionado");
}

// Consultar los servicios asociados al pedido
$query = "SELECT ps.id_servicio, s.nombre 
          FROM Pedido_Servicio ps 
          INNER JOIN Servicios s ON ps.id_servicio = s.id_servicio 
          WHERE ps.id_pedido = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();

$servicios = [];
while ($row = $result->fetch_assoc()) {
    $servicios[] = $row;
}
$stmt->close();

// Obtener los detalles del usuario y su pedido
$query_usuario = "SELECT u.id, u.username, u.email, u.address, u.phone 
                  FROM usuarios u 
                  INNER JOIN Pedidos p ON p.id_usuario = u.id 
                  WHERE p.id_pedido = ?";
$stmt_usuario = $conn->prepare($query_usuario);
$stmt_usuario->bind_param("i", $id_pedido);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$usuario_data = $result_usuario->fetch_assoc();
$stmt_usuario->close();

// Consultar la aclaración del pedido
$query_aclaracion = "SELECT descripcion FROM Pedidos WHERE id_pedido = ?";
$stmt_aclaracion = $conn->prepare($query_aclaracion);
$stmt_aclaracion->bind_param("i", $id_pedido);
$stmt_aclaracion->execute();
$result_aclaracion = $stmt_aclaracion->get_result();
$aclaracion = $result_aclaracion->fetch_assoc();
$stmt_aclaracion->close();

// Comprobar si la dirección y teléfono existen
$direccion = $usuario_data['address'] ?? 'No disponible';
$telefono = $usuario_data['phone'] ?? 'No disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Finalizar Pedido</title>
    <link rel="stylesheet" href="css/estiloFinal.css">
</head>
<body>

    <form action="finalizar_pedido.php" method="post">
    <h1>Finalizar Pedido</h1>
        <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">

        <!-- Datos del Usuario -->
        <h3>Datos del Cliente</h3>
        <label><strong>Nombre de usuario:</strong></label>
        <p><?php echo htmlspecialchars($usuario_data['username']); ?></p>

        <label><strong>Correo electrónico:</strong></label>
        <p><?php echo htmlspecialchars($usuario_data['email']); ?></p>

        <label><strong>Dirección:</strong></label>
        <p><?php echo htmlspecialchars($direccion); ?></p>

        <label><strong>Teléfono:</strong></label>
        <p><?php echo htmlspecialchars($telefono); ?></p>

        <!-- Aclaración del Pedido -->
        <h3>Aclaración del Pedido</h3>
        <p><?php echo htmlspecialchars($aclaracion['descripcion']); ?></p>
       
        <!-- Servicios y precios -->
        <h3>Servicios</h3>
        <?php foreach ($servicios as $servicio): ?>
            <label><?php echo htmlspecialchars($servicio['nombre']); ?></label>
            <input type="number" step="0.01" name="precios[<?php echo htmlspecialchars($servicio['id_servicio']); ?>]" placeholder="Indique el precio" required><br>

            <label>Cantidad:</label>
            <input type="number" name="cantidades[<?php echo htmlspecialchars($servicio['id_servicio']); ?>]" placeholder="Indique la cantidad" required><br><br>
        <?php endforeach; ?>

        <button type="submit">Finalizar y Generar PDF</button>
    </form>
</body>
</html>
