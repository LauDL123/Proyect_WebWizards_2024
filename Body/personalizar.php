<?php
session_start();
include "../Backend/backend_DB.php"; 

$error = '';
$username = $_SESSION['username']; 

// Obtener los datos actuales del usuario
$sql = "SELECT username, email, address, phone FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($current_username, $current_email, $current_address, $current_phone);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_email = $_POST['nuevo_email'];
    $nueva_direccion = $_POST['nueva_direccion'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nueva_foto = $_FILES['nueva_foto'];

    // Actualizar nombre de usuario si se proporciona
    if (!empty($nuevo_nombre) && $nuevo_nombre != $current_username) {
        $sql = "UPDATE usuarios SET username = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nuevo_nombre, $username);
        if (!$stmt->execute()) {
            $error = "Error al actualizar el nombre.";
        } else {
            $_SESSION['username'] = $nuevo_nombre; // Actualiza el nombre de usuario en la sesión
        }
        $stmt->close();
    }

    // Actualizar email si se proporciona
    if (!empty($nuevo_email) && $nuevo_email != $current_email) {
        $sql = "UPDATE usuarios SET email = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nuevo_email, $username);
        if (!$stmt->execute()) {
            $error = "Error al actualizar el email.";
        }
        $stmt->close();
    }

    // Actualizar dirección si se proporciona
    if (!empty($nueva_direccion) && $nueva_direccion != $current_address) {
        $sql = "UPDATE usuarios SET address = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nueva_direccion, $username);
        if (!$stmt->execute()) {
            $error = "Error al actualizar la dirección.";
        }
        $stmt->close();
    }

    // Actualizar teléfono si se proporciona
    if (!empty($nuevo_telefono) && $nuevo_telefono != $current_phone) {
        $sql = "UPDATE usuarios SET phone = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nuevo_telefono, $username);
        if (!$stmt->execute()) {
            $error = "Error al actualizar el teléfono.";
        }
        $stmt->close();
    }

    // Actualizar foto si se proporciona
    if ($nueva_foto['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $nueva_foto['tmp_name'];
        $file_name = basename($nueva_foto['name']);
        $upload_dir = '../uploads/';
        $upload_file = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp, $upload_file)) {
            // Actualiza la ruta de la foto en la base de datos
            $sql = "UPDATE usuarios SET photo = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $upload_file, $username);
            if (!$stmt->execute()) {
                $error = "Error al actualizar la foto.";
            }
            $stmt->close();
        } else {
            $error = "Error al subir el archivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalizar Perfil</title>
    <link rel="stylesheet" href="../css/estilo22.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
    <script src="../Scripts/controlMenu.js"></script>
    <link rel="icon" href="../img/key-chain.ico" type="image/x-icon">
</head>
<body>
    <!-- Barra de menú -->
<header>
    <?php include "../Backend/reusables/navbar.php"?>
</header>

    <h2>Personalizar Perfil</h2>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="../Body/personalizar.php" method="POST" enctype="multipart/form-data">
<<<<<<< Updated upstream
    <label for="nuevo_nombre">Nuevo Nombre:</label>
    <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo htmlspecialchars($username); ?>"><br><br>
    
    <label for="nuevo_email">Nuevo Email:</label>
    <input type="email" id="nuevo_email" name="nuevo_email" value="<?php echo htmlspecialchars($email); ?>"><br><br>
    
    <label for="nueva_direccion">Nueva Dirección:</label>
    <input type="text" id="nueva_direccion" name="nueva_direccion" value="<?php echo htmlspecialchars($address); ?>"><br><br>
    
    <label for="nuevo_telefono">Nuevo Teléfono:</label>
    <input type="text" id="nuevo_telefono" name="nuevo_telefono" value="<?php echo htmlspecialchars($phone); ?>"><br><br>
    
    <label for="nueva_foto">Nueva Foto:</label>
    <input type="file" id="nueva_foto" name="nueva_foto"><br><br>
    
    <button type="submit">Actualizar</button>
</form>

=======
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <label for="nuevo_apelldo">Nuevo Apellido:</label>
        <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $username; ?>" required><br><br>
        <label for="nuevo_foto">Nueva Foto:</label>
        <input type="file" id="nuevo_foto" name="nuevo_foto"><br><br>
        <button type="submit">Actualizar</button>
    </form>
>>>>>>> Stashed changes
       <!-- Footer -->
    <footer>
      <?php include "../Backend/reusables/footer.php"?>
    </footer>
    </body>

</html>
