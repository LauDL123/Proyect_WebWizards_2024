<?php
session_start();
?>

<!-- Barra de menú -->
<header>
<div class="header__logo">
<img src="../img/logoCerrajeria.jpg" alt="Logo de la Empresa" />
    </div>
    <nav class="nav">
    <div class="menu-icon" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
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
