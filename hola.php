<?php
session_start();
require_once 'Backend/backend_DB.php';


// Verificar si el administrador ha iniciado sesión
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}


// Consulta para obtener servicios
$get_servicios = "SELECT * FROM Servicios"; // Cambiado a "servicios"
$run_servicios = mysqli_query($conn, $get_servicios);
if ($run_servicios) {
    $cont_servicios = mysqli_num_rows($run_servicios);
} else {
    die("Error en la consulta de servicios: " . mysqli_error($conn));
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo22.css">
    <link rel="stylesheet" href="css/bootstrap-337.min.css">
    <title>Document</title>
</head>
<body>
<header>
    <?php include "Backend/reusables/navbar.php"?>
</header>
    <h1>hola</h1>

    <div id="page-wrapper">
            <div class="container-fluid">

                <?php
               
                if (isset($_GET['panel'])) {
                    include("Admin/adminPanel.php");
                } elseif (isset($_GET['insertar_servicio'])) {
                    include("insertar_servicio.php");
                } elseif (isset($_GET['ver_servicio'])) {
                    include("ver_servicio.php");
                } elseif (isset($_GET['editar_servicio'])) {
                    include("editar_servicio.php");
                } elseif (isset($_GET['borrar_servicio'])) {
                    include("borrar_servicio.php");
                } 
                
                ?>

            </div>
        </div>
    </div>

    <script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>
</body>
</html>