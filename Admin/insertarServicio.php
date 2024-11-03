<?php
session_start();
require_once 'Backend/backend_DB.php'; // Conexión a la base de datos

// Verificar si el usuario es administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

// Inicializar variables para los mensajes de error y éxito
$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen'];

    // Validar datos
    if (empty($nombre) || empty($precio) || empty($descripcion)) {
        $error_message = "Por favor, complete todos los campos.";
    } else {
        // Manejo de la imagen
        $targetDir = "img/";
        $targetFile = $targetDir . basename($imagen["name"]);
        $uploadOk = true;

        // Verificar si el archivo es una imagen
        $check = getimagesize($imagen["tmp_name"]);
        if ($check === false) {
            $error_message = "El archivo no es una imagen válida.";
            $uploadOk = false;
        }

        // Intentar subir la imagen
        if ($uploadOk && move_uploaded_file($imagen["tmp_name"], $targetFile)) {
            // Insertar el servicio en la base de datos
            $stmt = $conn->prepare("INSERT INTO servicios (nombre, precio, descripcion, imagen) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $nombre, $precio, $descripcion, $targetFile);

            if ($stmt->execute()) {
                $success_message = "Servicio agregado exitosamente.";
            } else {
                $error_message = "Error al insertar el servicio: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "Error al subir la imagen.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insertar Servicio</title>
    <link rel="stylesheet" href="css/bootstrap-337.min.css">
</head>
<body>
    <div class="container">
        <h2>Insertar Nuevo Servicio</h2>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (!empty($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Formulario para insertar un nuevo servicio -->
        <form action="insertarServicio.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del Servicio:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Servicio:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Servicio</button>
        </form>
    </div>

<script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>
</body>
</html>
