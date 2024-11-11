<?php
// Display de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Verifica si el usuario está logueado
if (isset($_SESSION['id'])) {
    // Obtener los datos del usuario desde la sesión
    $email = $_SESSION['email'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
    $nombre = $_SESSION['username'];  
} else {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $servicio_id = $_GET['id']; // El ID del servicio que se pasa por la URL

    // Conexión a la base de datos
    include "Backend/backend_DB.php";

    // Obtener el servicio seleccionado para autocompletar
    $sql = "SELECT * FROM Servicios WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $servicio_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $servicio = $result->fetch_assoc(); // Recuperar los datos del servicio
    } else {
        echo "Servicio no encontrado.";
        exit();
    }
} else {
    echo "No se ha seleccionado un servicio.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/key-chain.ico" type="image/x-icon">
    <title>Generar Pedido</title>
    <link rel="stylesheet" href="../css/estilo22.css">
    <link rel="stylesheet" href="Admin/css/usuarios.css">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <h1>Realizar Pedido</h1>
    <h3>
        <?php
            if (!isset($_SESSION['id'])) {
                echo 'Para disfrutar de una mejor experiencia le recomendamos iniciar sesión, así tendrá acceso al chat en tiempo real. Si lo desea, hágalo desde aquí <a href="Login_P.php">Iniciar sesión</a>';
            } else {
                echo "Bienvenido " . $_SESSION['username'];
            }
        ?>
    </h3>
    <nav>
        <a id="volverPanel" href="index.php">Volver al inicio</a>
    </nav>
</header>

<h2>Formulario de Pedido</h2>
<form action="procesar_pedido.php" method="POST">
    <div class="input-group">
        <label for="servicio">Servicio Seleccionado:</label>
        <input type="text" id="servicio" name="servicio" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" readonly>
    </div>
    <div class="input-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" readonly>
    </div>
    <div class="input-group">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
    </div>
    <div class="input-group">
        <label for="telefono">Número de Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($phone); ?>" readonly>
    </div>
    <div class="input-group">
        <label for="aclaracion">Aclaraciones (Opcional):</label>
        <textarea id="aclaracion" name="aclaracion"></textarea>
    </div>
    <div class="input-group">
        <button type="submit" id="submit" name="submit">Realizar Pedido</button>
    </div>
</form>

<script>
    // Al enviar el formulario, mostrar un alert y redirigir al index
    document.querySelector("form").addEventListener("submit", function(e) {
        e.preventDefault();  // Evitar el envío inmediato
        alert("Pedido realizado con éxito");
        window.location.href = "index.php";  // Redirigir al inicio
    });
</script>

</body>
</html>
