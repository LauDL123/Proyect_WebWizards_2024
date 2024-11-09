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

    // Inicia la transacción para asegurar que todas las operaciones se completen correctamente
    $conn->begin_transaction();

    try {
        // Eliminar el usuario de la tabla Admin si existe
        $query = "DELETE FROM Admin WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        // Eliminar el usuario de la tabla Clientes si existe
        $query = "DELETE FROM Clientes WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        // Eliminar los mensajes asociados al usuario
        $query = "DELETE FROM Mensajes WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        // Eliminar los pedidos asociados al usuario
        $query = "DELETE FROM Pedidos WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        // Eliminar los recibos asociados a los pedidos
        $query = "DELETE FROM Recibos WHERE id_pedido IN (SELECT id_pedido FROM Pedidos WHERE id_usuario = ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        // Eliminar el usuario de la tabla usuarios
        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        // Si todo fue exitoso, se confirma la transacción
        $conn->commit();

        // Redirige a la página de usuarios con mensaje de éxito
        header("Location: usuarios.php?message=Usuario eliminado con éxito.");
    } catch (Exception $e) {
        // Si ocurre un error, se revierte la transacción
        $conn->rollback();

        // Redirige a la página de usuarios con mensaje de error
        header("Location: usuarios.php?message=Error al eliminar el usuario.");
    }

    // Cierra la declaración
    $stmt->close();
} else {
    // Si no se pasó un ID, redirige con un mensaje de error
    header("Location: usuarios.php?message=ID de usuario no proporcionado.");
}

$conn->close();
?>
