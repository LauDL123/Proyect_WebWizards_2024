<?php
// Display de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Verifica si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirige al inicio si no es administrador
    header("Location: index.php");
    exit();
}

include "../Backend/backend_DB.php";

// Verifica si se ha enviado el id del servicio
if (isset($_GET['id'])) {
    $id_servicio = $_GET['id'];

    // Consulta el servicio con el id proporcionado
    $sql = "SELECT * FROM Servicios WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_servicio);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si el servicio existe, lo cargamos en el formulario
    if ($resultado->num_rows > 0) {
        $servicio = $resultado->fetch_assoc();
    } else {
        echo "Servicio no encontrado.";
        exit();
    }
} else {
    echo "ID de servicio no proporcionado.";
    exit();
}

// Procesar la edición del servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];

    // Subir la nueva imagen si se ha proporcionado
    if (!empty($imagen)) {
        $target_dir = "../img/";
        $target_file = $target_dir . basename($imagen);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
    } else {
        // Si no se sube nueva imagen, se mantiene la actual
        $imagen = $servicio['imagen'];
    }

    // Actualizar la información del servicio
    $sql_update = "UPDATE Servicios SET nombre = ?, descripcion = ?, imagen = ? WHERE id_servicio = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $nombre, $descripcion, $imagen, $id_servicio);

    if ($stmt_update->execute()) {
        echo "Servicio actualizado correctamente.";
        header("Location: servicios.php");
        exit();
    } else {
        echo "Error al actualizar el servicio.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/key-chain.ico" type="image/x-icon">

    <title>Editar Servicio</title>
    <link rel="stylesheet" href="../css/estilo22.css">
    <link rel="stylesheet" href="css/editarServicio.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
</head>
<body>

    <h1>Editar Servicio</h1>
    <nav>
        <a href="../adminPanel.php">Volver al Panel</a>
        <br>
        <a href="servicios.php">Volver a la lista de servicios</a>
    </nav>

    <form action="editar_servicio.php?id=<?php echo $servicio['id_servicio']; ?>" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="4" required><?php echo htmlspecialchars($servicio['descripcion']); ?></textarea>

        <label for="imagen">Imagen (deja en blanco para mantener la actual):</label>
        <input type="file" name="imagen" id="imagen">

        <button type="submit">Actualizar Servicio</button>
    </form>

    <footer>
        <?php include "../Backend/reusables/footer.php"; ?>
    </footer>
</body>
</html>
