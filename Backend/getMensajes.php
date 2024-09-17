<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'DB_web');

// Verifica si la conexión fue exitosa
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Consulta para obtener los mensajes
$sql = "SELECT m.contenido, u.username, m.fecha FROM Mensajes m JOIN usuarios u ON m.id_usuario = u.id ORDER BY m.id_mensaje ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Muestra los mensajes
    while($row = $result->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($row['username']) . ":</strong> " . htmlspecialchars($row['contenido']) . " <em>[" . $row['fecha'] . "]</em></p>";
    }
} else {
    echo "No hay mensajes.";
}

$conn->close();
