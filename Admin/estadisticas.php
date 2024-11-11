<?php

// Display de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión
include('../Backend/backend_DB.php');


// Consulta para obtener la cantidad de pedidos por estado
$query_pedidos_estado = "SELECT estado, COUNT(id_pedido) AS cantidad FROM Pedidos GROUP BY estado";
$result_pedidos_estado = $conn->query($query_pedidos_estado);

// Consulta para obtener los servicios más solicitados
$query_servicios_mas_solicitados = "SELECT Servicios.nombre, COUNT(Pedido_Servicio.id_servicio) AS cantidad 
                                    FROM Pedido_Servicio 
                                    JOIN Servicios ON Pedido_Servicio.id_servicio = Servicios.id_servicio 
                                    GROUP BY Pedido_Servicio.id_servicio 
                                    ORDER BY cantidad DESC LIMIT 5";
$result_servicios_mas_solicitados = $conn->query($query_servicios_mas_solicitados);

// Consulta para obtener la cantidad de usuarios registrados por mes
$query_usuarios_mes = "SELECT MONTH(usuarios.fecha_registro) AS mes, COUNT(usuarios.id) AS cantidad 
                        FROM usuarios 
                        GROUP BY mes ORDER BY mes";
$result_usuarios_mes = $conn->query($query_usuarios_mes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <h1>Estadísticas del Sistema</h1>
    
    <!-- Gráfico de cantidad de pedidos por estado -->
    <h3>Pedidos por Estado</h3>
    <div id="grafico_pedidos_estado" style="width: 900px; height: 500px;"></div>

    <!-- Gráfico de los servicios más solicitados -->
    <h3>Servicios más Solicitados</h3>
    <div id="grafico_servicios_solicitados" style="width: 900px; height: 500px;"></div>

    <!-- Gráfico de usuarios registrados por mes -->
    <h3>Usuarios Registrados por Mes</h3>
    <div id="grafico_usuarios_mes" style="width: 900px; height: 500px;"></div>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Gráfico de cantidad de pedidos por estado
            var dataPedidosEstado = google.visualization.arrayToDataTable([
                ['Estado', 'Cantidad'],
                <?php
                while($row = $result_pedidos_estado->fetch_assoc()) {
                    echo "['" . $row['estado'] . "', " . $row['cantidad'] . "],";
                }
                ?>
            ]);

            var optionsPedidosEstado = {
                title: 'Pedidos por Estado',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'Cantidad de Pedidos',
                    minValue: 0
                },
                vAxis: {
                    title: 'Estado'
                }
            };

            var chartPedidosEstado = new google.visualization.BarChart(document.getElementById('grafico_pedidos_estado'));
            chartPedidosEstado.draw(dataPedidosEstado, optionsPedidosEstado);

            // Gráfico de los servicios más solicitados
            var dataServiciosSolicitados = google.visualization.arrayToDataTable([
                ['Servicio', 'Cantidad'],
                <?php
                while($row = $result_servicios_mas_solicitados->fetch_assoc()) {
                    echo "['" . $row['nombre'] . "', " . $row['cantidad'] . "],";
                }
                ?>
            ]);

            var optionsServiciosSolicitados = {
                title: 'Servicios más Solicitados',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'Cantidad de Solicitudes',
                    minValue: 0
                },
                vAxis: {
                    title: 'Servicios'
                }
            };

            var chartServiciosSolicitados = new google.visualization.BarChart(document.getElementById('grafico_servicios_solicitados'));
            chartServiciosSolicitados.draw(dataServiciosSolicitados, optionsServiciosSolicitados);

            // Gráfico de usuarios registrados por mes
            var dataUsuariosMes = google.visualization.arrayToDataTable([
                ['Mes', 'Cantidad'],
                <?php
                while($row = $result_usuarios_mes->fetch_assoc()) {
                    echo "['" . $row['mes'] . "', " . $row['cantidad'] . "],";
                }
                ?>
            ]);

            var optionsUsuariosMes = {
                title: 'Usuarios Registrados por Mes',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'Cantidad de Usuarios',
                    minValue: 0
                },
                vAxis: {
                    title: 'Mes'
                }
            };

            var chartUsuariosMes = new google.visualization.BarChart(document.getElementById('grafico_usuarios_mes'));
            chartUsuariosMes.draw(dataUsuariosMes, optionsUsuariosMes);
        }
    </script>
</body>
</html>
