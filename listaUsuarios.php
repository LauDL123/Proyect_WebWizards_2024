<?php
// Conexión a la base de datos
include "Backend/backend_DB.php";

// Verifica si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirige al inicio si no es administrador
    header("Location: index.php");
    exit();
}

// Obtener todos los usuarios que han enviado mensajes
$query = "SELECT DISTINCT u.id_usuario, u.nombre 
          FROM usuarios u 
          INNER JOIN Mensajes m ON u.id_usuario = m.id_usuario 
          ORDER BY u.nombre ASC";
$resultado = mysqli_query($conexion, $query);
?>

<h2>Lista de Usuarios</h2>
<ul>
<?php while ($usuario = mysqli_fetch_assoc($resultado)) : ?>
    <li>
        <a href="chat.php?id_usuario=<?php echo $usuario['id_usuario']; ?>">
            <?php echo htmlspecialchars($usuario['nombre']); ?>
        </a>
    </li>
<?php endwhile; ?>
</ul>
