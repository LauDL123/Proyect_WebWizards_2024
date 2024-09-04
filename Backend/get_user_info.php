<?php
session_start();

// Configurar el tipo de contenido como JSON
header('Content-Type: application/json');

try {
    // Verificar si el usuario está logueado
    if (isset($_SESSION['username'])) {
        $response = array(
            "loggedIn" => true,
            "userPhoto" => "uploads/" . $_SESSION['foto'],
            "userName" => $_SESSION['username']
        );
    } else {
        $response = array(
            "loggedIn" => false,
            "userPhoto" => "",
            "userName" => ""
        );
    }

    // Devolver la respuesta JSON
    echo json_encode($response);
} catch (Exception $e) {
    // En caso de error, devolver un JSON con un mensaje de error
    echo json_encode(array(
        "loggedIn" => false,
        "userPhoto" => "",
        "userName" => "",
        "error" => $e->getMessage()
    ));
}
?>
