<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Mensaje</title>
    <link rel="stylesheet" href="../css/estilo22.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">

<script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css de practica.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .input-group input, .input-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .input-group textarea {
            height: 150px;
            resize: vertical;
        }
        .input-group button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .input-group button:hover {
            background-color: #0056b3;
        }
    </style>
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

    <div class="container">
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
</body>
</html>
