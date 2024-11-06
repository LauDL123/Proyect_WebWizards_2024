<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit();
}

include '../Backend/backend_DB.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Obtener la información del usuario
    $stmt = $conn->prepare("SELECT username, email, is_admin FROM usuarios WHERE id = ?");
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
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE usuarios SET username = ?, email = ?, is_admin = ? WHERE id = ?");
    $stmt->bind_param("ssii", $username, $email, $is_admin, $id);

    if ($stmt->execute()) {
        header("Location: usuarios.php");
        exit();
    } else {
        echo "Error al actualizar el usuario.";
    }
}

$conn->close();
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

        <div class="checkbox-container">
        <label for="is_admin">Administrador:</label>
        <input type="checkbox" name="is_admin" id="is_admin" <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
        </div>

        <button type="submit">Guardar Cambios</button>
        <a href="usuarios.php">Cancelar</a>
    </form>

</body>
</html>
