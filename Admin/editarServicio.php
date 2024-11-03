<?php
session_start();
require_once 'Backend/backend_DB.php'; // Conexión a la base de datos

// Verificar si el usuario es administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha pasado un ID válido por la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: verServicios.php");
    exit();
}

$id = $_GET['id'];

// Obtener los datos actuales del servicio
$query = $conn->prepare("SELECT * FROM servicios WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    // Si no existe el servicio, redirige de vuelta a la lista de servicios
    header("Location: verServicios.php");
    exit();
}

$servicio = $result->fetch_assoc();

// Procesar el formulario al enviar los nuevos datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    // Si se ha subido una nueva imagen, procesarla
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen'];
        $targetDir = "img/";
        $targetFile = $targetDir . basename($imagen["name"]);

        if (move_uploaded_file($imagen["tmp_name"], $targetFile)) {
            $imagenPath = $targetFile;
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    } else {
        // Si no se subió una nueva imagen, mantener la actual
        $imagenPath = $servicio['imagen'];
    }

    // Actualizar los datos en la base de datos
    $updateStmt = $conn->prepare("UPDATE servicios SET nombre = ?, precio = ?, descripcion = ?, imagen = ? WHERE id = ?");
    $updateStmt->bind_param("sdssi", $nombre, $precio, $descripcion, $imagenPath, $id);

    if ($updateStmt->execute()) {
        header("Location: verServicios.php");
        exit();
    } else {
        echo "Error al actualizar el servicio: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Servicio</title>
    <link rel="stylesheet" href="css/bootstrap-337.min.css">
</head>
<body>
    <div class="container">
        <h2>Editar Servicio</h2>
        
        <form action="editarServicio.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del Servicio</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" class="form-control" step="0.01" value="<?php echo htmlspecialchars($servicio['precio']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo htmlspecialchars($servicio['descripcion']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="imagen">Imagen (opcional)</label><br>
                <img src="<?php echo $servicio['imagen']; ?>" width="150" height="100" alt="Imagen actual"><br><br>
                <input type="file" name="imagen" id="imagen" class="form-control-file">
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="verServicios.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

<script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>
</body>
</html>
