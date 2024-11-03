<?php
include "backend_DB.php";
$clienteId = $_POST['clienteId']; // Cambiado a clienteId para coincidir con scriptChat.js
$result = $conn->query("SELECT texto FROM mensajes WHERE id_usuario = $clienteId");

$mensajes = [];
while ($row = $result->fetch_assoc()) {
    $mensajes[] = $row;
}
echo json_encode($mensajes);
?>