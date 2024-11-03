<?php
include 'Backend/backend_DB.php';

function crearUsuarioAdmin($username, $password, $email, $address, $phone) {
    global $conn;

    
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el usuario en la tabla 'usuarios'
    $query = "INSERT INTO usuarios (username, password, email, address, phone) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $passwordHash, $email, $address, $phone);
    
    if ($stmt->execute()) {
        // Obtener el ID del usuario recién creado
        $id_usuario = $stmt->insert_id;

        // Insertar en la tabla 'Admin' para hacer que sea administrador
        $queryAdmin = "INSERT INTO Admin (id_usuario, privilegios) VALUES (?, 'todos')";
        $stmtAdmin = $conn->prepare($queryAdmin);
        $stmtAdmin->bind_param("i", $id_usuario);

        if ($stmtAdmin->execute()) {
            echo "Usuario administrador creado con éxito.";
        } else {
            echo "Error al otorgar privilegios de administrador: " . $stmtAdmin->error;
        }
    } else {
        echo "Error al crear el usuario: " . $stmt->error;
    }
}

// Llama a la función con los datos del nuevo usuario administrador
crearUsuarioAdmin("Admin", "AdminCerrajeria", "cerrajeriaaranguren4@gmail.com", "123 Admin St", "5551234567");
?>
