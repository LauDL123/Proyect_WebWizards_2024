<?php
// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (isset($_SESSION['id'])) {
    // Obtener los datos del usuario desde la sesión
    $email = $_SESSION['email'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
    $nombre = $_SESSION['username'];  
} else {
    header("Location: Login_P.php");
    exit();
}

// Verificar si se ha recibido el parámetro 'id'
if (isset($_GET['id'])) {
    // Asigna el valor de `id` de la URL a `$servicio_id`
    $servicio_id = (int)$_GET['id'];  // Fuerza el valor a entero para evitar conflictos

    // Conexión a la base de datos
    include "Backend/backend_DB.php";

    // Consulta para obtener el servicio seleccionado
    $sql = "SELECT * FROM Servicios WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit();
    }
    $stmt->bind_param("i", $servicio_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $servicio = $result->fetch_assoc();
    } else {
        echo "Servicio no encontrado.";
        exit();
    }

    // Obtener todos los servicios disponibles para añadir más al pedido
    $sql_servicios = "SELECT id_servicio, nombre FROM Servicios WHERE visible = 1 AND id_servicio != ?";
    $stmt_servicios = $conn->prepare($sql_servicios);
    $stmt_servicios->bind_param("i", $servicio_id);
    $stmt_servicios->execute();
    $result_servicios = $stmt_servicios->get_result();
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
    <title>Generar Pedido</title>
    <link rel="stylesheet" href="css/estilo22.css">
    <link rel="stylesheet" href="css/css_Pedido.css">
</head>
<body>
<header>
    <h1>Realizar Pedido</h1>
    <nav>
        <a id="volverPanel" href="index.php">Volver al inicio</a>
    </nav>
</header>

<h2>Formulario de Pedido</h2>
<form action="Backend/procesar_pedido.php" method="POST">
    <div class="input-group">
        <label for="servicio">Servicio Seleccionado:</label>
        <input type="text" id="servicio" name="servicio" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" readonly>
    </div>
    
    <!-- Mostrar otros servicios disponibles para agregar al pedido -->
    <div class="input-group">
        <label for="otros_servicios">Otros Servicios (Seleccione si desea añadir más):</label><br>
        <?php
        if ($result_servicios->num_rows > 0) {
            while ($servicio_extra = $result_servicios->fetch_assoc()) {
                echo "<input type='checkbox' name='otros_servicios[]' value='" . $servicio_extra['id_servicio'] . "'> " . $servicio_extra['nombre'] . "<br>";
            }
        } else {
            echo "No hay más servicios disponibles para añadir.";
        }
        ?>
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

</body>
</html>
