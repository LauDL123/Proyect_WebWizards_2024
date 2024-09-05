<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebWizards</title>
    <link rel="stylesheet" href="../css/estilo22.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">

<script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css de practica.css">
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
    <h1>Team WebWizards:</h1>

    <h3>Lautaro de León</h3>

    <p>Gmail: <a href="lautadeleon222@gmail.com">lautadeleon222@gmail.com</a></p>
    <p>Github: <a href="https://github.com/LauDL123">https://github.com/LauDL123</a></p>
    <p>LinkedIn: <a href="https://www.linkedin.com/in/lautaro-de-león">www.linkedin.com/in/lautaro-de-león</a></p>

    <h3>Juan Aranguren</h3>

    <p>Gmail: <a href="juandiegoarangurenmartinez@gmail.com">juandiegoarangurenmartinez@gmail.com</a></p>
    <p>Github: <a href="https://github.com/Juandiex">https://github.com/Juandiex</a></p>
    <p>LinkedIn: <a href="">tiene que crearlo</a></p>
   
    <h3>Tabaré Quintana:</h3>

    <p>Gmail: <a href="tabaquintana@gmail.com">tabaquintana@gmail.com</a></p>
    <p>Github: <a href="https://github.com/TabareQuintana">https://github.com/TabareQuintana</a></p>
    <p>LinkedIn: <a href="https://www.linkedin.com/in/nitquintana">www.linkedin.com/in/nitquintana</a></p>

    <h3>Feliciano May</h3>

    <p>Gmail: <a href="felicianomay735@gmail.com">felicianomay735@gmail.com</a></p>
    <p>Github: <a href="https://github.com/Spongiboby">https://github.com/Spongiboby</a></p>
    <p>LinkedIn: <a href="https://www.linkedin.com/in/feliciano-may-98b881318"> www.linkedin.com/in/feliciano-may-98b881318</a></p>

</body>
</html>