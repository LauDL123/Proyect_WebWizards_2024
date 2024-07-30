<<<<<<< Updated upstream:index.php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrajería Aranguren</title>
    <link rel="stylesheet" href="estilo22.css">

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
    <!-- Carousel Start -->
    <div class="slider-frame">
        <ul>
            <li><img src="cerrajeria1.JPG" alt=""></li>
            <li><img src="cerradura.jpg" alt=""></li>
            <li><img src="img-Cerrajero.png" alt=""></li>
            <li><img src="cerrajeria2.png" alt=""></li>
        </ul>
    </div>
    <!-- Carousel End -->

    <!-- Listado de productos -->
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mt-8">Nuestros Servcios</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 1" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Producto 1</h3>
                    <p class="text-gray-600">Descripción del producto 1.</p>
                    <button class="btn-contacto">Contacto</button>
                </div>
            </div>
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 2" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Producto 2</h3>
                    <p class="text-gray-600">Descripción del producto 2.</p>
                    <button class="btn-contacto">Contacto</button>
                </div>
            </div>
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 3" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Producto 3</h3>
                    <p class="text-gray-600">Descripción del producto 3.</p>
                    <button class="btn-contacto">Contacto</button>
                </div>
            </div>
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 4" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Producto 4</h3>
                    <p class="text-gray-600">Descripción del producto 4.</p>
                    <button class="btn-contacto">Contacto</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Botón flotante -->


    <a href="mensaje.php" class="floating-button">
    <i class="fa-solid fa-comment-dots"></i>
</a>

    <!-- Botón para mostrar el formulario de mensaje -->
    <button id="btn_mostrar_formulario" onclick="mostrarFormulario()">Enviar Mensaje</button>

    <!-- Formulario de mensaje -->
    <form id="mensaje_formulario" action="backend_EnviarMensaje.php" method="POST">
        <h2>Enviar Mensaje</h2>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required><br><br>
        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" rows="4" cols="50" required></textarea><br><br>
        <button type="submit">Enviar</button>
    </form>
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 powered by WebWizards</p>
        <p><a href="historial.php">Historial de la Empresa</a></p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
=======
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrajería Aranguren</title>
    <link rel="stylesheet" href="css de practica.css">

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
                <li class="nav__li"><i class="fas fa-home"></i><a href="index.html">Inicio</a></li>
                <li class="nav__li"><i class="fa-solid fa-user"></i><a href="sobre_Nosotros.html">Sobre Nosotros</a></li>
                <li class="nav__li"><i class="fa-solid fa-car"></i><a href="productos.html">Visitas</a></li>
                <li class="nav__li"><i class="fa-solid fa-circle-question"></i><a href="ayuda.html">Ayuda</a></li>
                <li class="nav__li nav__li--right"><i class="fa-solid fa-circle-user" id="iniciar"></i><a href="Login_P.html">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <!-- Carousel Start -->
    <div class="slider-frame">
        <ul>
            <li><img src="cerrajeria1.JPG" alt=""></li>
            <li><img src="cerradura.jpg" alt=""></li>
            <li><img src="img-Cerrajero.png" alt=""></li>
            <li><img src="cerrajeria2.png" alt=""></li>
        </ul>
    </div>
    <!-- Carousel End -->

    <!-- Listado de productos -->
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mt-8">Nuestros servicios</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 1" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Servicio 1</h3>
                    <p class="text-gray-600">Descripción del servicio</p>
                    <button class="btn-contacto">Saber más</button>
                </div>
            </div>
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 2" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Servicio 2</h3>
                    <p class="text-gray-600">Descripción del servicio</p>
                    <button class="btn-contacto">Saber más</button>
                </div>
            </div>
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 3" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Servicio 3</h3>
                    <p class="text-gray-600">Descripción del servicio</p>
                    <button class="btn-contacto">Saber más</button>
                </div>
            </div>
            <div class="bg-light-gray shadow rounded-lg overflow-hidden">
                <img src="https://placehold.co/300x200" alt="Product 4" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="text-lg font-bold">Servcio 4</h3>
                    <p class="text-gray-600">Descripción del servicio</p>
                    <button class="btn-contacto">Saber más</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón para mostrar el formulario de mensaje -->
    <button id="btn_mostrar_formulario" onclick="mostrarFormulario()">Enviar Mensaje</button>

    <!-- Formulario de mensaje -->
    <form id="mensaje_formulario" action="backend_EnviarMensaje.php" method="POST">
        <h2>Enviar Mensaje</h2>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required><br><br>
        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" rows="4" cols="50" required></textarea><br><br>
        <button type="submit">Enviar</button>
    </form>
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 WebWizards</p>
        <p><a href="historial.html">Historial de la Empresa</a></p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
>>>>>>> Stashed changes:index.html
