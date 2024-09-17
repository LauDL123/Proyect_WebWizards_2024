<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat de Cerragería</title>
    <link rel="stylesheet" href="../css/estiloChat.css">
    <link rel="stylesheet" href="../css/estilo22.css">
    <script src="../Scripts/controlMenu.js"></script>
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
</head>
<header>
    <?php include "../Backend/reusables/navbar.php"?>
</header>
<body>


    <h3><?php
            if (!isset($_SESSION['email'])) {
                // Si no está logueado, redirige al login
                header("Location: Login_P.php");
                exit();
            }else {
                echo "Bienvenido: " . $_SESSION['username'] ;
            }
        ?>
    </h3>
    <h1>Sistema de mensajeria en tiempo real</h1>
    <h3>En este campo, hablaras directamente con el dueño del establecimiento. Escribele un mensaje y se te notificara cuando te conteste. Es un sistema similar a Whatsapp</h3>
    <div class="chat-container">
        <div class="messages-container" id="mensajes">
          <!--aca se muestran los mensajes-->
        </div>
        
        <div class="input-container">
            <textarea id="mensaje" placeholder="Escribe tu mensaje..."></textarea>
            <button onclick="enviarMensaje()">Enviar</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../Scripts/scriptChat.js"></script>
</body>
</html>
