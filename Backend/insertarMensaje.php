<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['email'])) {
    echo "Usuario no logueado.";
    exit();
}

// Obtiene el ID del usuario desde la sesión
$id_usuario = $_SESSION['id'];

// Verifica si se ha enviado un mensaje
if (isset($_POST['contenido'])) {
    $contenido = $_POST['contenido'];

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'DB_web');

    // Verifica si la conexión fue exitosa
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }

    // Inserta el mensaje en la base de datos
    $stmt = $conn->prepare("INSERT INTO Mensajes (contenido, id_usuario) VALUES (?, ?)");
    $stmt->bind_param("si", $contenido, $id_usuario);

    if ($stmt->execute()) {
        echo "Mensaje insertado correctamente.";
    } else {
        echo "Error al insertar el mensaje.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No se ha enviado ningún contenido.";
}
