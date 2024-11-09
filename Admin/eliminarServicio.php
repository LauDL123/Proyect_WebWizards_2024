<?php
session_start();

// Verificar si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirige al inicio si no es administrador
    header("Location: ../index.php");
    exit();
}

// Conexión a la base de datos
require_once '../Backend/backend_DB.php';

// Verificar si se recibió un ID válido para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_servicio = $_GET['id'];

    // Preparar la consulta para eliminar el servicio
    $sql = "DELETE FROM Servicios WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_servicio);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Servicio eliminado correctamente.";
    } else {
        echo "Error al eliminar el servicio: " . $conn->error;
    }

    // Cerrar la consulta y la conexión
    $stmt->close();
    $conn->close();

    // Redirigir a la página de servicios después de eliminar
    header("Location: servicios.php");
    exit();
} else {
    echo "ID de servicio no válido.";
}
?>
