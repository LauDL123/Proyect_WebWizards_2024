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

    < class="container">
        <h2>Enviar Mensaje</h2>
        <form action="procesar_mensaje.php" method="POST">
            <div class="input-group">
                <label for="numero">Número de Teléfono:</label>
                <input type="text" id="numero" name="numero" required>
            </div>
            <div class="input-group">
                <label for="nombre">Nombre del Remitente:</label>
                <input type="text" id="nombre" name="nombre" required>
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
