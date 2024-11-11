<?php
session_start();

// Verificar si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirige al inicio si no es administrador
    header("Location: index.php");
    exit();
}

include "../Backend/backend_DB.php";

// Consultar todos los pedidos
$sql = "SELECT * FROM Pedidos";  
$resultado = $conn->query($sql);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

    <h1>Lista de Pedidos</h1>
    
    <?php if ($resultado->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID de Pedido</th>
                <th>Cliente</th>
                <th>Fecha de Pedido</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pedido = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                    <td><?php echo htmlspecialchars($pedido['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($pedido['fecha_pedido']); ?></td>
                    <td>
                        <?php 
                            if ($pedido['estado'] == 1) {
                                echo "Pendiente";
                            } elseif ($pedido['estado'] == 2) {
                                echo "Tomado";
                            } else {
                                echo "Finalizado";
                            }
                        ?>
                    </td>
                    <td>
                        <?php if ($pedido['estado'] == 1): ?>
                            <a href="Backend/tomar_pedido.php?id=<?php echo $pedido['id_pedido']; ?>" class="btn-tomar">Tomar Pedido</a>
                        <?php elseif ($pedido['estado'] == 2): ?>
                            <a href="Backend/finalizar_pedido.php?id=<?php echo $pedido['id_pedido']; ?>" class="btn-finalizar">Finalizar Pedido</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay pedidos registrados.</p>
    <?php endif; ?>

    <footer>
      <?php include "../Backend/reusables/footer.php"?>
    </footer>
</body>
</html>
