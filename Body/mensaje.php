<?php
session_start();

//Verificar si el usuario ha iniciado sesión
// Si lo hizo autorellenar los campos
if (isset($_SESSION['id'])) {
    $email = $_SESSION['email'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
} else {
    //Si no ha iniciado sesión, dejar los campos vacíos
    $email = '';
    $address = '';
    $phone = '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>
    <link rel="stylesheet" href="../css/enviarMensaje.css">
    <link rel="stylesheet" href="../css/estilo22.css">
    <script src="../Scripts/controlMenu.js"></script>
    <link rel="icon" href="../img/key-chain.ico" type="image/x-icon">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">

<script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
    
</head>
<body>
<!-- Barra de menú -->
<header>
    <?php include "../Backend/reusables/navbar.php"?>
</header>

    <div class="container">
    <h3>
        <?php
            if (!isset($_SESSION['id'])) {
                // Si no está logueado, se le recomienda hacerlo
                echo 'Para disfrutar de una mejor experiencia le recomendamos iniciar sesión, así tendrá acceso al chat en tiempo real. Si lo desea, hágalo desde aquí <a href="Login_P.php">Iniciar sesión</a>';
            } else {
                echo "Bienvenido " . $_SESSION['username'];
            }
        ?>
    </h3>

    <h2>Enviar Mensaje</h2>
        <form action="../Backend/procesar_mensaje.php" method="POST">
            <div class="input-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="input-group">
                <label for="numero">Número de Teléfono:</label>
                <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>
            <div class="input-group">
                <label for="nombre">Nombre del Remitente:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
            </div>
            <div class="input-group">
                <label for="asunto">Asunto:</label>
                <input type="text" id="asunto" name="asunto" required>
            </div>
            <div class="input-group">
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
            </div>
            <div class="input-group">
                <button type="submit">Enviar Mensaje</button>
            </div>
        </form>
    </div>
       <!-- Footer -->
    <footer>
      <?php include "../Backend/reusables/footer.php"?>
    </footer>
</body>
</html>
