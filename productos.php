<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="css/estilo22.css">
    <link rel="icon" href="img/key-chain.ico" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
    <script src="Scripts/controlMenu.js"></script>
</head>
<body>
  <!-- Barra de menú -->
<header>
    <?php include "Backend/reusables/navbar.php"?>
</header>


    <h1>Servicios</h1>

    <!-- Listado de servicios -->
    <div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mt-8">Nuestros Servicios</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
        <div class="producto producto--default">
            <img src="https://placehold.co/300x200" alt="Product 1" class="producto-img" />
            <div class="producto-text">
                <h3 class="text-lg font-bold">Instalacion de cerradura</h3>
                <p class="text-gray-600">Descripción del producto 1.</p>
            </div>

        </div>
        <div class="producto producto--reverse">
            <div class="producto-text">
                <h3 class="text-lg font-bold">Apertura de puertas</h3>
                <p class="text-gray-600">Descripcion del producto 2</p>
            </div>
            <img src="https://placehold.co/300x200" alt="Product 2" class="producto-img" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
        <div class="producto producto--default">
            <img src="https://placehold.co/300x200" alt="Product 1" class="producto-img" />
            <div class="producto-text">
                <h3 class="text-lg font-bold">Cambio de conbinacon</h3>
                <p class="text-gray-600">Descripción del producto 1.</p>
            </div>
        <!-- Añadir más productos según sea necesario -->
    </div>
</div>

 <div class="producto producto--reverse">
            <div class="producto-text">
                <h3 class="text-lg font-bold">duplicado de llaves</h3>
                <p class="text-gray-600">Hay que hacer que el texto quede en la izquierda y la imgen en la derecha, no centrada. producto 2.</p>
            </div>
            <img src="https://placehold.co/300x200" alt="Product 2" class="producto-img" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
        <div class="producto producto--default">
            <img src="https://placehold.co/300x200" alt="Product 1" class="producto-img" />
            <div class="producto-text">
                <h3 class="text-lg font-bold">Producto 1</h3>
                <p class="text-gray-600">Descripción del producto 1.</p>
            </div>
        <!-- Añadir más productos según sea necesario -->
    </div>
</div>
<div class="producto producto--reverse">
            <div class="producto-text">
                <h3 class="text-lg font-bold">Producto 2</h3>
                <p class="text-gray-600">Hay que hacer que el texto quede en la izquierda y la imgen en la derecha, no centrada. producto 2.</p>
            </div>
            <img src="https://placehold.co/300x200" alt="Product 2" class="producto-img" />
        </div>

       <!-- Footer -->
    <footer>
      <?php include "Backend/reusables/footer.php"?>
    </footer>

   
</div>
</body>
</html>