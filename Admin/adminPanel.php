
<?php
session_start();
require_once 'Backend/backend_DB.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el administrador ha iniciado sesión
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

// Consulta para obtener servicios
$get_servicios = "SELECT * FROM Servicios";
$run_servicios = mysqli_query($conn, $get_servicios);
if ($run_servicios) {
    $cont_servicios = mysqli_num_rows($run_servicios);
} else {
    die("Error en la consulta de servicios: " . mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="css/bootstrap-337.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
   
</head>
<body>
<div id="wrapper">

<?php include("includes/sidebar.php"); ?>

    <div id="page-wrapper">
        <div class="container-fluid">

            <?php
                if (isset($_GET['panel'])) {
                    include("panel.php");
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
    <h1>sss</h1>

<script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>
</body>
</html>
