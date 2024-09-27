<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" href="../css/css_navbar.css">
    <title>intento 2 navbar responsive</title>
</head>
<body>

<!-- Barra de menú -->
<header>

<div class="header__logo">
<img src="../img/logoCerrajeria1.jpg" alt="Logo de la Empresa" />
    </div>

    <div class="menu_bar">
			<a href="#" class="bt-menu"><i id="barras" class="fas fa-bars"></i><img src="../img/logoCerrajeria1.jpg" alt="Logo de la Empresa" /></a>
		</div>


    <nav class="nav">

        <ul class="nav_ul">
            <li class="nav__li"><i class="fas fa-home"></i><a href="index.php">Inicio</a></li>
            <li class="nav__li"><i class="fa-solid fa-user"></i><a href="sobre_Nosotros.php">Sobre Nosotros</a></li>
            <li class="nav__li"><i class="fa-solid fa-key"></i><a href="productos.php">Servicios</a></li>
            <li class="nav__li"><i class="fa-solid fa-circle-question"></i><a href="ayuda.php">Ayuda</a></li>
            <li class="nav__li nav__li--right">
                <?php
                if (isset($_SESSION['username'])) {
                    // Verificar que 'foto' esté definido
                    $userPhoto = isset($_SESSION['foto']) ? htmlspecialchars($_SESSION['foto']) : 'default.png';
                    $username = htmlspecialchars($_SESSION['username']);
                    
                    echo '
                    <div class="user-info" onclick="toggleUserMenu()">
                        <img src="../Backend/uploads/' . $userPhoto . '" alt="Foto de Usuario">
                        <span>' . $username . '</span>
                    </div>
                    <div class="user-menu" id="userMenu">
                        <a href="../Body/personalizar.php">Personalizar</a>
                        <a href="../Backend/logout.php">Cerrar Sesión</a>
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
<script src="../Scripts/navbarMobile.js"></script>
</body>
</html>