<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header("Location: Login_P.php");
    exit();
}

$username = $_SESSION['username'];
include "Backend/backend_DB.php"; 

// Verificar que la conexión sea exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del usuario
$sql = "SELECT id, username, email, address, phone, foto FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id, $current_username, $current_email, $current_address, $current_phone, $current_photo);
$stmt->fetch();
$stmt->close();

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_email = $_POST['nuevo_email'];
    $nueva_direccion = $_POST['nueva_direccion'];
    $nuevo_telefono = $_POST['nuevo_telefono'];

    // Actualizar nombre de usuario
    if (!empty($nuevo_nombre) && $nuevo_nombre != $current_username) {
        $sql = "UPDATE usuarios SET username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nuevo_nombre, $user_id);
        if ($stmt->execute()) {
            $_SESSION['username'] = $nuevo_nombre;
            $username = $nuevo_nombre;
        } else {
            $error = "Error al actualizar el nombre.";
        }
        $stmt->close();
    }

    // Actualizar email
    if (!empty($nuevo_email) && $nuevo_email != $current_email) {
        $sql = "UPDATE usuarios SET email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nuevo_email, $user_id);
        if (!$stmt->execute()) {
            $error = "Error al actualizar el email.";
        }
        $stmt->close();
    }

    // Actualizar dirección
    if (!empty($nueva_direccion) && $nueva_direccion != $current_address) {
        $sql = "UPDATE usuarios SET address = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nueva_direccion, $user_id);
        if (!$stmt->execute()) {
            $error = "Error al actualizar la dirección.";
        }
        $stmt->close();
    }

    // Actualizar teléfono
    if (!empty($nuevo_telefono) && $nuevo_telefono != $current_phone) {
        $sql = "UPDATE usuarios SET phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nuevo_telefono, $user_id);
        if (!$stmt->execute()) {
            $error = "Error al actualizar el teléfono.";
        }
        $stmt->close();
    }

    // Procesar la imagen de perfil
    if (isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['nueva_foto']['tmp_name'];
        $file_ext = pathinfo($_FILES['nueva_foto']['name'], PATHINFO_EXTENSION);
        $file_name = 'profile_' . $user_id . '.' . $file_ext;

        // Definir la ruta de destino para la imagen
        $rutaDestino = "uploads/$file_name";

        // Mover la imagen a la carpeta deseada
        if (move_uploaded_file($file_tmp, $rutaDestino)) {
            // Establecer permisos 777 para la imagen
            chmod($rutaDestino, 0777);

            $sql = "UPDATE usuarios SET foto = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $file_name, $user_id);
            if (!$stmt->execute()) {
                $error = "Error al actualizar la foto de perfil.";
            }
            $stmt->close();

            // Actualizar la sesión con el nombre de la foto
            $_SESSION['foto'] = $file_name;  // Añade esta línea
            
            $current_photo = $file_name; // Actualizar la variable de foto actual
        } else {
            $error = "Error al subir la foto.";
        }
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Personalizar Perfil</title>
    <link rel="stylesheet" href="css/estilo22.css">
    <link rel="stylesheet" href="css/css_Personalizar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Barra de menú -->
    <header>
        <?php include "Backend/reusables/navbar.php"?>
    </header>
    <h1>Personalizar Perfil</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="nuevo_nombre">Nombre de Usuario:</label>
        <input type="text" name="nuevo_nombre" value="<?php echo htmlspecialchars($current_username); ?>"><br>

        <label for="nuevo_email">Correo Electrónico:</label>
        <input type="email" name="nuevo_email" value="<?php echo htmlspecialchars($current_email); ?>"><br>

        <label for="nueva_direccion">Dirección:</label>
        <input type="text" name="nueva_direccion" value="<?php echo htmlspecialchars($current_address); ?>"><br>

        <label for="nuevo_telefono">Teléfono:</label>
        <input type="text" name="nuevo_telefono" value="<?php echo htmlspecialchars($current_phone); ?>"><br>

        <label for="nueva_foto">Foto de Perfil:</label>
        <input type="file" name="nueva_foto"><br>
        
        <?php if ($current_photo): ?>
            <img src="uploads/<?php echo $current_photo; ?>" alt="Foto de Perfil" width="150"><br>
        <?php endif; ?>

        <button type="submit">Actualizar Perfil</button>
    </form>
</body>
</html>
