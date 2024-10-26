<?php
// Código para destruir la sesión y redirigir al usuario a la página de inicio
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
exit();
?>
