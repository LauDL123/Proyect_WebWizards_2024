<?php
session_start();
require 'backend_DB.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: Login_P.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $newName = $_POST['nombre'];
    $photoPath = '';

    // Procesar la subida de la foto de perfil
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileSize = $_FILES['foto']['size'];
        $fileType = $_FILES['foto']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Asignar un nombre único al archivo subido y especificar la ruta de destino
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './uploads/';
        $photoPath = $uploadFileDir . $newFileName;

        // Mover el archivo subido al directorio de destino
        if(move_uploaded_file($fileTmpPath, $photoPath)) {
            // El archivo se movió con éxito
        } else {
            $_SESSION['error'] = 'Hubo un error al subir el archivo.';
            header('Location: personalizar.php');
            exit();
        }
    }

    // Actualizar la información del usuario en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET username = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("ssi", $newName, $photoPath, $userId);
    if ($stmt->execute()) {
        // Actualizar la información en la sesión
        $_SESSION['user_name'] = $newName;
        $_SESSION['user_photo'] = $photoPath;
        
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Hubo un error al actualizar el perfil.';
        header('Location: personalizar.php');
        exit();
    }
}
?>
