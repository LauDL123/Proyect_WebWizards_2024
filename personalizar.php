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
$sql = "SELECT username, email, address, phone, foto FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($current_username, $current_email, $current_address, $current_phone, $current_photo);
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
        $sql = "UPDATE usuarios SET username = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nuevo_nombre, $username);
        if ($stmt->execute()) {
            $_SESSION['username'] = $nuevo_nombre;
            $username = $nuevo_nombre; // Actualiza la variable $username
        } else {
            $error = "Error al actualizar el nombre.";
        }
        $stmt->close();
    }

    // Actualizar email
    if (!empty($nuevo_email) && $nuevo_email != $current_email) {
        $sql = "UPDATE usuarios SET email = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nuevo_email, $username);
        if (!$stmt->execute()) {
            $error = "Error al actualizar el email.";
        }
        $stmt->close();
    }

    // Actualizar dirección
    if (!empty($nueva_direccion) && $nueva_direccion != $current_address) {
        $sql = "UPDATE usuarios SET address = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nueva_direccion, $username);
        if (!$stmt->execute()) {
            $error = "Error al actualizar la dirección.";
        }
        $stmt->close();
    }

    // Actualizar teléfono
    if (!empty($nuevo_telefono) && $nuevo_telefono != $current_phone) {
        $sql = "UPDATE usuarios SET phone = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nuevo_telefono, $username);
        if (!$stmt->execute()) {
            $error = "Error al actualizar el teléfono.";
        }
        $stmt->close();
    }

    // Manejar la subida de la nueva foto de perfil
    if (isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'Backend/uploads/usuarios/' . $username . '/';

        // Verifica si el directorio existe, si no, intenta crearlo
        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                die('Error al crear el directorio: ' . $upload_dir);
            }
        }

        $file_name = basename($_FILES['nueva_foto']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['nueva_foto']['tmp_name'], $target_file)) {
            $sql = "UPDATE usuarios SET foto = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $file_name, $username); // Usa solo el nombre de archivo
            if ($stmt->execute()) {
                $_SESSION['foto'] = $file_name; // Actualiza la sesión
            } else {
                $error = "Error al actualizar la foto.";
            }
            $stmt->close(); // Cierra solo aquí
        } else {
            $error = "Error al subir la foto.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewports" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/personalizar.css">
    <link rel="stylesheet" href="css/estilo22.css">
    <title>Personalizar Perfil</title>
</head>
<body>
<header>
    <?php include "Backend/reusables/navbar.php"?>
</header>
    <h1>Personalizar Perfil</h1>
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" id="nuevo_nombre" value="<?= htmlspecialchars($current_username) ?>">

        <label for="nuevo_email">Nuevo Email:</label>
        <input type="email" name="nuevo_email" id="nuevo_email" value="<?= htmlspecialchars($current_email) ?>">

        <label for="nueva_direccion">Nueva Dirección:</label>
        <input type="text" name="nueva_direccion" id="nueva_direccion" value="<?= htmlspecialchars($current_address) ?>">

        <label for="nuevo_telefono">Nuevo Teléfono:</label>
        <input type="text" name="nuevo_telefono" id="nuevo_telefono" value="<?= htmlspecialchars($current_phone) ?>">

        <label for="nueva_foto">Nueva Foto de Perfil:</label>
        <input type="file" name="nueva_foto" id="nueva_foto" accept="image/*">

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
