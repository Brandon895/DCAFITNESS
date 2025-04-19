<?php
// Archivo: controllers/ProgresoFisicoController.php

require_once '../models/ProgresoFisicoModel.php';  // Incluir el modelo

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
    $medidas = ProgresoFisicoModel::obtenerMedidasPorCedula($cedula);

    if ($medidas) {
        echo '<h2>Resultados de las Medidas</h2>';
        echo '<table border="1" style="width:100%; text-align: center;">
                <thead>
                    <tr>
                        <th>Fecha Medición</th>
                        <th>Peso</th>
                        <th>Altura</th>
                        <th>IMC</th>
                        <th>Porcentaje Grasa</th>
                        <th>Circunferencia Cintura</th>
                        <th>Circunferencia Bíceps</th>
                        <th>Circunferencia Tríceps</th>
                        <th>Circunferencia Muslo</th>
                        <th>Circunferencia Pantorrilla</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($medidas as $medida) {
            echo '<tr>';
            echo '<td>' . $medida['fecha_medicion'] . '</td>';
            echo '<td>' . $medida['peso'] . '</td>';
            echo '<td>' . $medida['altura'] . '</td>';
            echo '<td>' . $medida['imc'] . '</td>';
            echo '<td>' . $medida['porcentaje_grasa'] . '</td>';
            echo '<td>' . $medida['circunferencia_cintura'] . '</td>';
            echo '<td>' . $medida['circunferencia_biceps'] . '</td>';
            echo '<td>' . $medida['circunferencia_triceps'] . '</td>';
            echo '<td>' . $medida['circunferencia_muslo'] . '</td>';
            echo '<td>' . $medida['circunferencia_pantorrilla'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';

        // Mostrar gráficos
        echo '<h3>Progreso Físico</h3>';
        echo '<div style="display: flex; flex-wrap: wrap; justify-content: space-around;">';

        // Lista de medidas y sus tipos de gráficos
        $medidasGraficos = [
            'peso' => 'line',
            'altura' => 'bar',
            'imc' => 'radar',
            'porcentaje_grasa' => 'pie',
            'circunferencia_cintura' => 'doughnut',
            'circunferencia_biceps' => 'polarArea',
            'circunferencia_triceps' => 'line',
            'circunferencia_muslo' => 'bar',
            'circunferencia_pantorrilla' => 'radar'
        ];

        foreach ($medidasGraficos as $key => $tipo) {
            echo '<div style="width: 30%; margin: 10px;">
                    <canvas id="' . $key . 'Chart" width="300" height="150"></canvas>
                  </div>';
        }

        echo '</div>';

        // Scripts para los gráficos
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        echo '<script>';
        foreach ($medidasGraficos as $key => $tipo) {
            echo '
                var ctx = document.getElementById("' . $key . 'Chart").getContext("2d");
                var ' . $key . 'Chart = new Chart(ctx, {
                    type: "' . $tipo . '",
                    data: {
                        labels: ' . json_encode(array_column($medidas, 'fecha_medicion')) . ',
                        datasets: [{
                            label: "' . ucfirst(str_replace('_', ' ', $key)) . '",
                            data: ' . json_encode(array_column($medidas, $key)) . ',
                            backgroundColor: "rgba(75, 192, 192, 0.6)",
                            borderColor: "rgba(75, 192, 192, 1)",
                            borderWidth: 1
                        }]
                    }
                });
            ';
        }
        echo '</script>';
    } else {
        echo "No se encontraron medidas para esa cédula.";
    }
}
?>
