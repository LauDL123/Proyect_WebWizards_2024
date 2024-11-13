<?php
// Display de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../Backend/backend_DB.php";
session_start();

// Verificar si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit();
}

// Configuración de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Consulta para obtener todos los pedidos junto con el nombre del cliente desde la tabla usuarios
$sql = "SELECT 
            Pedidos.id_pedido, 
            Pedidos.descripcion, 
            Pedidos.estado, 
            usuarios.username AS nombre_cliente
        FROM Pedidos
        INNER JOIN usuarios ON Pedidos.id_usuario = usuarios.id";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/key-chain.ico" type="image/x-icon">
    <title>Gestionar Pedidos</title>
    <link rel="stylesheet" href="../css/estilo22.css">
    <link rel="stylesheet" href="css/styleServicios.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h1>Gestión de Pedidos</h1>
        <nav>
            <a id="volverPanel" href="../adminPanel.php">Volver al Panel</a>
        </nav>
    </header>

    <main>
        <h1>Lista de Pedidos</h1>
        
        <?php if ($resultado && $resultado->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID de Pedido</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $resultado->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['nombre_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['descripcion']); ?></td>
                        <td>
                            <?php 
                                if ($pedido['estado'] == "pendiente") {
                                    echo "Pendiente";
                                } elseif ($pedido['estado'] == "tomado") {
                                    echo "Tomado";
                                } else {
                                    echo "Finalizado";
                                }
                            ?>
                        </td>
                        <td>
                            <?php if ($pedido['estado'] == "pendiente"): ?>
                                <a href="tomar_pedido.php?id=<?php echo $pedido['id_pedido']; ?>" class="btn-tomar">Tomar Pedido</a>
                            <?php elseif ($pedido['estado'] == "tomado"): ?>
                                <a href="formulario_final.php?id=<?php echo $pedido['id_pedido']; ?>" class="btn-finalizar">Finalizar Pedido</a>
                                <?php 
        elseif ($pedido['estado'] == "finalizado"): 
            // Ruta del archivo PDF de la factura
            $archivoPDF = "../facturas/factura_" . $pedido['id_pedido'] . ".pdf";
            
            // Verificar si el archivo PDF existe
            if (file_exists($archivoPDF)): 
    ?>
        <a href="<?php echo $archivoPDF; ?>" target="_blank" class="btn-ver-factura">Ver Factura</a>
    <?php 
            else:
                echo "Factura no disponible";
            endif;
    ?>
    <?php endif; ?>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No hay pedidos registrados.</p>
        <?php endif; ?>
    </main>

    <footer>
        <?php include "../Backend/reusables/footer.php"?>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
