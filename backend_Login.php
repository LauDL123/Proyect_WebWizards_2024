<?php
include 'backend_DB.php';

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
        // Establecer una cookie de sesión
        setcookie("username", $username, time() + (86400 * 30), "/"); // 86400 = 1 día

        // Iniciar sesión exitosamente y redirigir a index.php
        header("Location: index.php");
        exit();
    } else {
        // Fallo en el inicio de sesión
        echo "Usuario o contraseña incorrectos";
    }

    $stmt->close();
}
$conn->close();
?>
