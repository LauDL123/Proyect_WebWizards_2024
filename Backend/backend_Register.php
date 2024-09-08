<?php
include '../Backend/backend_DB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $defaultPhoto = 'default.png'; // Valor predeterminado para la foto del usuario

    // Prevenir inyecciones SQL
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);
    $address = mysqli_real_escape_string($conn, $address);
    $phone = mysqli_real_escape_string($conn, $phone);

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email, address, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $address, $phone);

    if ($stmt->execute()) {
        // Iniciar sesión exitosamente y redirigir al login
        header("Location: ../Body/Login_P.php?registro=exitoso");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
