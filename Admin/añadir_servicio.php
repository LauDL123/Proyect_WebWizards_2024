<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
require_once '../Backend/backend_DB.php';

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $imagen_nombre = '';
    $visible = 1; // Establecer el valor predeterminado de visible

    // Manejar la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        
        // Crear un nombre único para la imagen
        $imagen_nombre = uniqid('servicio_') . '.' . $imagen_extension;
        $imagen_destino = __DIR__ . '/../img/' . $imagen_nombre;

        // Mover la imagen a la carpeta `img`
        if (!move_uploaded_file($imagen_tmp, $imagen_destino)) {
            echo "Error al subir la imagen.";
            exit;
        }
    // Asignar permisos 777 a la imagen subida
    chmod($imagen_destino, 0777);
} else {
    echo "Por favor, sube una imagen válida.";
    exit;
}

    

    // Insertar el nuevo servicio en la base de datos con la ruta de la imagen
    $sql = "INSERT INTO Servicios (nombre, descripcion, imagen, visible) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $descripcion, $imagen_nombre, $visible);

    if ($stmt->execute()) {
        echo "Servicio añadido exitosamente.";
        header("Location: ../index.php"); // Redirigir a index.php
        exit;
    } else {
        echo "Error al añadir el servicio: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Servicio</title>
   
</head>
<body>
    <h2>Añadir Nuevo Servicio</h2>
    <form action="añadir_servicio.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre del Servicio:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="imagen">Subir Foto:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <button type="submit">Añadir Servicio</button>
    </form>
</body>
</html>
