<?php
session_start();
include '../Backend/backend_DB.php'; // Archivo de conexión a la base de datos
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$query = "SELECT m.contenido AS mensaje, u.username, m.fecha 
          FROM Mensajes m 
          JOIN usuarios u ON m.id_usuario = u.id 
          ORDER BY m.id_mensaje ASC";

$result = $conn->query($query);

$mensajes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mensajes[] = [
            'username' => htmlspecialchars($row['username']),
            'mensaje' => htmlspecialchars($row['mensaje']),
            'timestamp' => $row['fecha']
        ];
    }
}
header('Content-Type: application/json');
echo json_encode($mensajes);
?>