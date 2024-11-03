<?php
session_start();
include '../Backend/backend_DB.php'; // Archivo de conexión a la base de datos

if (isset($_POST['contenido']) && isset($_POST['id_usuario'])) {
    $mensaje = $conn->real_escape_string($_POST['contenido']);
    $id_usuario = $conn->real_escape_string($_POST['id_usuario']);

    $query = "INSERT INTO Mensajes (id_usuario, contenido) VALUES ('$id_usuario', '$mensaje')";
    $conn->query($query);
}
?>
