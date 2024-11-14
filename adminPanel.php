<?php
session_start();

// Verifica si el usuario tiene permisos de administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirige al inicio si no es administrador
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/key-chain.ico" type="image/x-icon">

    <title>Panel Admin</title>
    <link rel="stylesheet" href="css/estilo22.css">
    <link rel="stylesheet" href="css/stylePanelA.css">
    <link rel="stylesheet" href="css/css_navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2ff8e04842.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
</head>
<body>
<header>
    <?php include "Backend/reusables/navbar.php"?>
</header>
<div class="titulo-panel">
        <h1>Panel de Administración</h1>
    </div>
    <div class="container">
        
           <div class="sidebar">
            <nav>
                
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="Admin/usuarios.php">Gestionar Usuarios</a></li>
                    <li><a href="Admin/servicios.php">Gestionar Servicios</a></li>
                    <li><a href="Admin/pedidos.php">Gestionar Pedidos</a></li>
                    <li><a href="Admin/estadisticas.php">Estadísticas</a></li>
                    <li><a href="Backend/logout.php">Cerrar Sesión</a></li>
                    
                </ul>
            </nav>
        </div>

        <main>
            <section>
                <h2>Resumen</h2>
                
                <div class="grafica">
                    <h3>Gráfico de Productos Disponibles</h3>
                    <div class="chart-placeholder">[Gráfico Aquí]</div>
                </div>
            </section>
        </main>
    </div>
    <script src="Scripts/controlMenu.js"></script>
    <script>
// Datos de ejemplo para el gráfico
const ctx = document.getElementById('graficoProductos').getContext('2d');
const graficoProductos = new Chart(ctx, {
    type: 'bar', // Tipo de gráfico (barras)
    data: {
        labels: ['Producto A', 'Producto B', 'Producto C', 'Producto D'], // Etiquetas de productos
        datasets: [{
            label: 'Cantidad disponible',
            data: [10, 20, 15, 25], // Datos de ejemplo
            backgroundColor: ['#4CAF50', '#FF5733', '#FFC300', '#C70039'],
            borderColor: ['#388E3C', '#C0392B', '#FFB300', '#900C3F'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>