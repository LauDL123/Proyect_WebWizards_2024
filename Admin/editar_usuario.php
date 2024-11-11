<?php
// Display de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit();
}

include '../Backend/backend_DB.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Obtener la información del usuario
    $stmt = $conn->prepare("SELECT username, email FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "Usuario no encontrado.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Corregir la consulta de actualización de usuario
    $stmt = $conn->prepare("UPDATE usuarios SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $id);

    if ($stmt->execute()) {
        // Verificar si se presionó el botón de "Asignar Administrador"
        if (isset($_POST['make_admin'])) {
            $stmt = $conn->prepare("INSERT INTO Admin (id_usuario, privilegios) VALUES (?, 'todos')");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }

        // Verificar si se presionó el botón de "Quitar Administrador"
        if (isset($_POST['remove_admin'])) {
            $stmt = $conn->prepare("DELETE FROM Admin WHERE id_usuario = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }

        // Redirigir después de la actualización
        header("Location: usuarios.php");
        exit();
    } else {
        echo "Error al actualizar el usuario.";
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/editarUsuario.css">
</head>
<body>
    <h1>Editar Usuario</h1>
    <form method="POST" action="">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <?php
        // Verificar si el usuario ya es administrador
        $is_admin = false;
        $stmt = $conn->prepare("SELECT * FROM Admin WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $admin_result = $stmt->get_result();
        if ($admin_result->num_rows > 0) {
            $is_admin = true;
        }
        ?>
        
        <?php if ($is_admin): ?>
            <button type="submit" name="remove_admin">Quitar Administrador</button>
        <?php else: ?>
            <button type="submit" name="make_admin">Asignar Administrador</button>
        <?php endif; ?>

        <button type="submit">Guardar Cambios</button>
        <a href="usuarios.php">Cancelar</a>
    </form>

</body>
</html>

<?php
$conn->close();
?>