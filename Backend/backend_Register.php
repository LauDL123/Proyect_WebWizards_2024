<?php
include '../Backend/backend_DB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $defaultPhoto = 'default.png'; // Valor predeterminado para la foto del usuario

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    // Prevenir inyecciones SQL
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);
    $address = mysqli_real_escape_string($conn, $address);
    $phone = mysqli_real_escape_string($conn, $phone);

   // Verificar que el usuario no exista
   $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? OR email = ?");
   $stmt->bind_param("ss", $username, $email);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
       echo "<script>alert('El usuario o el email ya están registrados.'); window.location.href='../Register.html';</script>";
   } else {
       // Insertar en la tabla usuarios
       $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email, address, phone) VALUES (?, ?, ?, ?, ?)");
       $stmt->bind_param("sssss", $username, $hashed_password, $email, $address, $phone);

       if ($stmt->execute()) {
           // Obtener el ID del usuario recién creado
           $user_id = $stmt->insert_id;

           // Insertar en la tabla Clientes
           $stmt_client = $conn->prepare("INSERT INTO Clientes (id_usuario, direccion) VALUES (?, ?)");
           $stmt_client->bind_param("is", $user_id, $address);
           $stmt_client->execute();

           echo "<script>window.location.href='../Login_P.php?registro=exitoso';</script>";
       } else {
           echo "<script>alert('Error en el registro, intenta nuevamente.'); window.location.href='../Register.html';</script>";
       }
   }

   $stmt->close();
   $conn->close();
}
?>
