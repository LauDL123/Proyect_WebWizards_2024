<?php
include 'backend_DB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevenir inyecciones SQL
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
       
         // Iniciar sesión exitosamente y redirigir a el login
         header("Location: Login_P.php?registro=exitoso");
         exit();
        
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
