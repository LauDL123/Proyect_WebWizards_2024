<?php
session_start();
require 'backend_BD.php';

$response = [
    'loggedIn' => false,
    'userName' => '',
    'userPhoto' => ''
];

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, foto FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username, $foto);
    if ($stmt->fetch()) {
        $response['loggedIn'] = true;
        $response['userName'] = $username;
        $response['userPhoto'] = $foto;
    }
    $stmt->close();
}

echo json_encode($response);
?>
