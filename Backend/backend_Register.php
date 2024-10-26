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

    // Verificar si el email ya está registrado
    $checkEmailQuery = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el correo ya existe, mostrar mensaje de error
        echo "<script>alert('El correo electrónico ya está registrado. Por favor, elija otro.'); window.location.href='../Register.html';</script>";
        $stmt->close();
        $conn->close();
        exit();
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email, address, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $address, $phone);

    if ($stmt->execute()) {
        // Iniciar sesión exitosamente y redirigir al login
        header("Location: ../Login_P.php?registro=exitoso");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
