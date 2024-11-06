<?php
session_start();

// Verifica si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit();
}

include '../Backend/backend_DB.php';

// Verifica si se ha pasado un ID de usuario
if (isset($_GET['id'])) {
    $id_usuario = (int)$_GET['id']; 
    var_dump($id_usuario);
    // Preparar la consulta para eliminar el usuario
    $query = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        // Si la eliminación fue exitosa, redirige a usuarios.php con un mensaje de éxito
        header("Location: usuarios.php?message=Usuario eliminado con éxito.");
    } else {
        // Si hubo un error, redirige a usuarios.php con un mensaje de error
        header("Location: usuarios.php?message=Error al eliminar el usuario.");
    }

    $stmt->close();
} else {
    // Si no se pasó un ID, redirige con un mensaje de error
    header("Location: usuarios.php?message=ID de usuario no proporcionado.");
}

$conn->close();
?>
