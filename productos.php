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
    <?php include "Backend/reusables/navbar.php"; ?>
  </header>

  <h1>Servicios</h1>

  <!-- Listado de servicios -->

  <div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mt-8">Nuestros Servicios</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
      <?php
      // Conexión a la base de datos
      require_once 'Backend/backend_DB.php';

      // Obtener los servicios de la base de datos
      $sql = "SELECT * FROM servicios WHERE visible = 1";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $nombre = $row['nombre'];
              $descripcion = $row['descripcion'];
              $imagen = $row['imagen'];
      ?>
        <div class="producto producto--default">
            <img src="img/<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>" class="producto-img" />
            <div class="producto-text">
                <h3 class="text-lg font-bold"><?php echo $nombre; ?></h3>
                <p class="text-gray-600"><?php echo $descripcion; ?></p>
            </div>
        </div>
      <?php
          }
      } else {
          echo "<p>No se encontraron servicios disponibles.</p>";
      }

      // Cerrar la conexión
      $conn->close();
      ?>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <?php include "Backend/reusables/footer.php"; ?>
  </footer>

</body>
</html>
