<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit();
}

include '../Backend/backend_DB.php';

// Obtener la lista de usuarios y verificar si son administradores
$query = "SELECT u.id, u.username, u.email, 
                 CASE WHEN a.id_usuario IS NOT NULL THEN 'Sí' ELSE 'No' END AS es_admin
          FROM usuarios u
          LEFT JOIN Admin a ON u.id = a.id_usuario";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/key-chain.ico" type="image/x-icon">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../css/estilo22.css">
    <link rel="stylesheet" href="css/styleServicios.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
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
                    <td><?php echo $row['es_admin']; ?></td>
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


    <footer>
      <?php include "../Backend/reusables/footer.php"?>
    </footer>

</html>

<?php
$conn->close();
?>
