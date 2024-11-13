<?php
session_start();

// Verifica si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirige al inicio si no es administrador
    header("Location: index.php");
    exit();
}

include "../Backend/backend_DB.php";

// Consultar todos los servicios
$sql = "SELECT * FROM Servicios";
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
    <title>Servicios</title>
    <link rel="stylesheet" href="../css/estilo22.css">
    <link rel="stylesheet" href="css/styleServicios.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
            <h1>Gestión de Servicios</h1>
        <nav>
            <a id="volverPanel" href="../adminPanel.php">Volver al Panel</a>
        </nav>
    </header>


    <h1>Lista de servicios</h1>
    <nav>
        <a id="volverPanel" href="añadir_servicio.php">Añadir Servicio</a>
    </nav>

    <?php if ($resultado->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID de servicio</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($servicio = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($servicio['id_servicio']); ?></td>
                    <td><?php echo htmlspecialchars($servicio['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($servicio['descripcion']); ?></td>
                    <td>
                        <?php if (!empty($servicio['imagen'])) : ?>
                            <img src="../img/<?php echo htmlspecialchars($servicio['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($servicio['nombre']); ?>" width="100">
                        <?php else : ?>
                            No hay imagen
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editar_servicio.php?id=<?php echo $servicio['id_servicio']; ?>">Editar</a>
                        <?php if ($servicio['visible']) : ?>
                            <a href="ocultarServicio.php?id=<?php echo $servicio['id_servicio']; ?>">Ocultar/Eliminar</a> |
                        <?php else : ?>
                            <a href="mostrarServicio.php?id=<?php echo $servicio['id_servicio']; ?>">Mostrar/Recuperar</a> |
                        <?php endif; ?>
                        <a href="eliminarServicio.php?id=<?php echo $servicio['id_servicio']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?');">Eliminar Definitivamente</a>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay ningún servicio registrado.</p>
    <?php endif; ?>

    <footer>
      <?php include "../Backend/reusables/footer.php"?>
    </footer>
</body>
</html>
