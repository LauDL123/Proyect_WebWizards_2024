<?php
session_start();
require_once 'Backend/backend_DB.php'; 

// Consulta para obtener los servicios visibles
$sql = "SELECT nombre, descripcion, imagen FROM Servicios WHERE visible = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/key-chain.ico" type="image/x-icon">
    <title>Cerrajería Aranguren</title>
    <link rel="stylesheet" href="css/estilo22.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
</head>
<body>

<!-- Barra de menú -->
<header>
    <?php include "Backend/reusables/navbar.php" ?>
</header>


<!-- Listado de servicios -->
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mt-8">Nuestros Servicios</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="producto producto--default">
                    <img src="img/<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" class="producto-img" />
                    <div class="producto-text">
                        <h3 class="text-lg font-bold"><?php echo htmlspecialchars($row['nombre']); ?></h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                        <a href="chat.php" class="contact-button" style="background-color: #4299e1; color: #fff; padding: 0.5rem 1rem; border-radius: 0.25rem; display: inline-block; margin-top: 0.5rem;">Contáctanos</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay servicios disponibles en este momento.</p>
        <?php endif; ?>

    </div>
</div>

<script src="Scripts/slider.js"></script>
<script src="Scripts/controlMenu.js"></script>

<!-- Botón flotante -->
<a href="chat.php" class="floating-button">
    <i class="fa-solid fa-comment-dots"></i>
</a>

<!-- Footer -->
<footer>
    <?php include "Backend/reusables/footer.php" ?>
</footer>

</body>
</html>

<?php
$conn->close();
?>
