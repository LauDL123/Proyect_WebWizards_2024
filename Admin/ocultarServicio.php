<?php
session_start();

// Verifica si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirige al inicio si no es administrador
    header("Location: index.php");
    exit();
}

include '../Backend/backend_DB.php';

// Verifica si se ha pasado el ID del servicio
if (isset($_GET['id'])) {
    $id_servicio = (int)$_GET['id'];

    // Prepara la consulta para actualizar el servicio y marcarlo como oculto
    $sql = "UPDATE Servicios SET visible = 0 WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_servicio);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Redirige con un mensaje de éxito
        header("Location: servicios.php?message=Servicio oculto correctamente.");
    } else {
        // Redirige con un mensaje de error
        header("Location: servicios.php?message=Error al ocultar el servicio.");
    }

    $stmt->close();
} else {
    // Redirige si no se pasó un ID
    header("Location: servicios.php?message=ID del servicio no proporcionado.");
}

$conn->close();
?>
