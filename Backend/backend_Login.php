<?php
include '../Backend/backend_DB.php';

session_start(); // Inicia la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevenir inyecciones SQL
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Consulta segura usando sentencias preparadas
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sesión con $_SESSION
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $user['email']; 
        $_SESSION['address'] = $user['address'];
        $_SESSION['phone'] = $user['phone'];

        // Redirigir a index.php
        header("Location: ../Body/index.php");
        exit();
    } else {
        // Fallo en el inicio de sesión
        echo "Usuario o contraseña incorrectos";
    }

    $stmt->close();
}
$conn->close();
?>
