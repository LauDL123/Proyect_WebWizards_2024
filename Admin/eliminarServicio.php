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

    // Iniciar una transacción para asegurarnos de que ambas eliminaciones sean atómicas
    $conn->begin_transaction();

    try {
        // Primero, eliminar los registros en la tabla Pedido_Servicio
        $sql_delete_pedido_servicio = "DELETE FROM Pedido_Servicio WHERE id_servicio = ?";
        $stmt_delete_pedido_servicio = $conn->prepare($sql_delete_pedido_servicio);
        $stmt_delete_pedido_servicio->bind_param("i", $id_servicio);
        $stmt_delete_pedido_servicio->execute();

        // Luego, eliminar el servicio de la tabla Servicios
        $sql_delete_servicio = "DELETE FROM Servicios WHERE id_servicio = ?";
        $stmt_delete_servicio = $conn->prepare($sql_delete_servicio);
        $stmt_delete_servicio->bind_param("i", $id_servicio);
        $stmt_delete_servicio->execute();

        // Si ambas consultas se ejecutan correctamente, confirmamos la transacción
        $conn->commit();

        // Redirigir a la página de servicios después de eliminar
        header("Location: servicios.php");
        exit();
    } catch (Exception $e) {
        // Si hay algún error, hacemos un rollback
        $conn->rollback();
        echo "Error al eliminar el servicio: " . $e->getMessage();
    } finally {
        // Cerrar las sentencias y la conexión
        $stmt_delete_pedido_servicio->close();
        $stmt_delete_servicio->close();
        $conn->close();
    }
} else {
    echo "ID de servicio no válido.";
}
?>
