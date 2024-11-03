<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define la ruta de la foto de usuario
if (isset($_SESSION['foto'])) {
    $photoPath = 'Backend/uploads/usuarios/' . $_SESSION['username'] . '/' . htmlspecialchars($_SESSION['foto']);
    // Verifica si la foto existe
    if (!file_exists($photoPath)) {
        $photoPath = 'Backend/uploads/default.png'; // Usa una imagen por defecto si no se encuentra
    }
} else {
    $photoPath = 'Backend/uploads/default.png'; 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" href="css/css_navbar.css">
    <title>Navbar</title>
</head>
<body>

<!-- Barra de menú -->
<header>
    <div class="header__logo">
        <img src="img/logoCerrajeria1.jpg" alt="Logo de la Empresa" />
    </div>

    <div class="menu_bar">
        <a href="#" class="bt-menu"><i id="barras" class="fas fa-bars"></i><img src="img/logoCerrajeria1.jpg" alt="Logo de la Empresa" /></a>
    </div>

    <nav class="nav">
        <ul class="nav_ul">
            <li class="nav__li"><i class="fas fa-home"></i><a href="index.php">Inicio</a></li>
            <li class="nav__li"><i class="fa-solid fa-user"></i><a href="sobre_Nosotros.php">Sobre Nosotros</a></li>
            <li class="nav__li"><i class="fa-solid fa-key"></i><a href="productos.php">Servicios</a></li>
            <li class="nav__li"><i class="fa-solid fa-circle-question"></i><a href="ayuda.php">Ayuda</a></li>
            
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                <li class="nav__li"><i class="fa-solid fa-tools"></i><a href="hola.php">Panel de Admin</a></li>
            <?php endif; ?>

            <li class="nav__li nav__li--right">
                <?php
                if (isset($_SESSION['username'])) {
                    $username = htmlspecialchars($_SESSION['username']);
                    
                    echo '
                    <div class="user-info" onclick="toggleUserMenu()">
                        <img src="' . $photoPath . '" alt="Foto de Usuario" style="width: 40px; height: 40px; border-radius: 50%;">
                        <span>' . $username . '</span>
                    </div>
                    <div class="user-menu" id="userMenu">
                        <a href="personalizar.php">Personalizar</a>
                        <a href="Backend/logout.php">Cerrar Sesión</a>
                    </div>';
                } else {
                    echo '<i class="fa-solid fa-circle-user" id="iniciar"></i><a href="Login_P.php">Iniciar Sesión</a>';
                }
                ?>
            </li>

            <li class="nav__li"><i class="fa-solid fa-paper-plane"></i><a href="mensaje.php">Escríbanos</a></li>
        </ul>
    </nav>
</header>

<script src="Scripts/navbarMobile.js"></script>
</body>
</html>
