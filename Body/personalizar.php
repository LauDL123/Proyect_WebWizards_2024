<?php
session_start();

$username = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_foto = $_FILES['nuevo_foto'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($nuevo_foto["name"]);
    move_uploaded_file($nuevo_foto["tmp_name"], $target_file);

    $sql = "UPDATE usuarios SET username = ?, foto = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nuevo_nombre, $target_file, $username);

    if ($stmt->execute()) {
        $_SESSION['username'] = $nuevo_nombre;
        $_SESSION['foto'] = $nuevo_foto["name"];
        header("Location: ../Body/index.php");
        exit();
    } else {
        $error = "Error al actualizar perfil";
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
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <label for="nuevo_apelldo">Nuevo Apellido:</label>
        <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $username; ?>" required><br><br>
        <label for="nuevo_foto">Nueva Foto:</label>
        <input type="file" id="nuevo_foto" name="nuevo_foto" required><br><br>
        <button type="submit">Actualizar</button>
    </form>
       <!-- Footer -->
    <footer>
      <?php include "../Backend/reusables/footer.php"?>
    </footer>
    </body>

</html>
