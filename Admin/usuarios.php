<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit();
}

include '../Backend/backend_DB.php';

// Obtener la lista de usuarios, incluyendo is_admin
$query = "SELECT id, username, email, is_admin FROM usuarios";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="css/usuarios.css">
</head>
<body>
    <header>
        <h1>Gestión de Usuarios</h1>
        <nav>
            <a id="volverPanel" href="../index.php">Volver al index</a>
        </nav>
    </header>
    <h1>Lista de usuarios</h1>
        <nav>
            <a id="volverPanel" href="../adminPanel.php">Volver al Panel</a>
        </nav>
    <main>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Es Administrador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo $row['is_admin'] == 1 ? 'Sí' : 'No'; ?></td>
                    <td>
                        <a class="accion" href="editar_usuario.php?id=<?php echo $row['id']; ?>">Editar</a> |
                        <a class="accion" href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if ($result->num_rows == 0): ?>
                    <tr>
                        <td colspan="5">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
$conn->close();
?>