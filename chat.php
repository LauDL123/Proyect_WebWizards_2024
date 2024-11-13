<?php
// Conexión a la base de datos
include "Backend/backend_DB.php";

// Obtener el ID del usuario seleccionado
$id_usuario = $_GET['id_usuario'];

// Consultar los mensajes entre el administrador y el usuario
$query = "SELECT * FROM Mensajes WHERE id_usuario = '$id_usuario' ORDER BY fecha_hora ASC";
$resultado = mysqli_query($conexion, $query);
?>

<h2>Chat con <?php echo htmlspecialchars($id_usuario); ?></h2>
<div class="chat-box">
    <?php while ($mensaje = mysqli_fetch_assoc($resultado)) : ?>
        <p><strong><?php echo htmlspecialchars($mensaje['id_usuario']); ?>:</strong> <?php echo htmlspecialchars($mensaje['mensaje']); ?></p>
    <?php endwhile; ?>
</div>

<form action="enviar_mensaje.php" method="POST">
    <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
    <textarea name="mensaje" required></textarea>
    <button type="submit">Enviar</button>
</form>
<a href="lista_usuarios.php">Volver a la lista de usuarios</a>
