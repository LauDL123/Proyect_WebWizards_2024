<?php
session_start();
require 'backend_DB.php';

if (!isset($_SESSION['username'])) {
    header("Location: Login_P.html");
    exit();
}

$username = $_SESSION['username'];

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
        header("Location: index.php");
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
    <link rel="stylesheet" href="css de practica.css">
</head>
<body>
     <!-- Barra de menú -->
<header>
    <nav class="nav">
        <ul class="nav_ul">
            <li class="nav__li"><i class="fas fa-home"></i><a href="index.php">Inicio</a></li>
            <li class="nav__li"><i class="fa-solid fa-user"></i><a href="sobre_Nosotros.php">Sobre Nosotros</a></li>
            <li class="nav__li"><i class="fa-solid fa-key"></i><a href="productos.php">Servcios</a></li>
            <li class="nav__li"><i class="fa-solid fa-circle-question"></i><a href="ayuda.php">Ayuda</a></li>
            <li class="nav__li nav__li--right">
                <?php
                session_start();
                if (isset($_SESSION['username'])) {
                    echo '
                    <div class="user-info" onclick="toggleUserMenu()">
                        <img src="uploads/' . $_SESSION['foto'] . '" alt="User Photo">
                        <span>' . $_SESSION['username'] . '</span>
                    </div>
                    <div class="user-menu" id="userMenu">
                        <a href="personalizar.php">Personalizar</a>
                        <a href="logout.php">Cerrar Sesión</a>
                    </div>';
                } else {
                    echo '<i class="fa-solid fa-circle-user" id="iniciar"></i><a href="Login_P.php">Iniciar Sesión</a>';
                }
                ?>
                <li class="nav__li"><i class="fa-solid fa-paper-plane"></i><a href="mensaje.php">Escribanos</a></li>
            </li>
        </ul>
    </nav>
</header>

    <h2>Personalizar Perfil</h2>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="personalizar_perfil.php" method="POST" enctype="multipart/form-data">
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $username; ?>" required><br><br>
        <label for="nuevo_foto">Nueva Foto:</label>
        <input type="file" id="nuevo_foto" name="nuevo_foto" required><br><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
