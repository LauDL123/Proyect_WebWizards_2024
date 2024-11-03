<?php
include "backend_DB.php";
$result = $conn->query("SELECT DISTINCT id_usuario, nombre FROM usuarios WHERE mensaje IS NOT NULL");

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}
echo json_encode($clientes);
?>