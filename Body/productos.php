<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="../css/estilo22.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
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
    <h1>Productos</h1>

    <!-- Listado de productos -->
    <div class="producto1">
        <h3>Producto 1</h3>
        <p>Descripción del producto 1.</p>
        <p>Precio: $XX.XX</p>
    </div>
    <div class="producto2">
        <h3>Producto 2</h3>
        <p>Descripción del producto 1.</p>
        <p>Precio: $XX.XX</p>
    </div>

    <div class="producto3">
        <h3>Producto 3</h3>
        <p>Descripción del producto 1.</p>
        <p>Precio: $XX.XX</p>
    </div>

    <div class="producto4">
        <h3>Producto 4</h3>
        <p>Descripción del producto 1.</p>
        <p>Precio: $XX.XX</p>
    </div>

    <div class="producto5">
        <h3>Producto 5</h3>
        <p>Descripción del producto 1.</p>
        <p>Precio: $XX.XX</p>
    </div>

    <!-- Botón para mostrar el formulario de mensaje -->
    <a href="mensaje.php" id="btn_mostrar_formulario">Enviar Mensaje</a>

   
</div>
</body>
</html>