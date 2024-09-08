<?php
include 'backend_DB.php';

// Comprobar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['username'])) {
    // Si el usuario no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header("Location: ../Body/Login_P.php");
    exit();
}

//
