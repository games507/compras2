<?php
session_start();
include 'conexion.php';
header('Content-Type: application/json');


$year_current = date("Y");

$sql_general = "SELECT estado, count(estado) as cantidad FROM wp_portalcompra GROUP BY estado ORDER BY cantidad DESC";
$resultado = $conn->query($sql_general);

$sql_current = "SELECT estado, count(estado) as cantidad FROM wp_portalcompra WHERE year(fecha_publicacion) = $year_current GROUP BY estado ORDER BY cantidad ASC";
$resultado_2 = $conn->query($sql_current);

$labels_gen = [];
$data_gen = [];
$backgroundColor_gen = ["#009639", "#00A9E0", "#7A7A7A", "#dee2e6"];
$labels_curr = [];
$data_curr = [];

while ($fila = $resultado->fetch_assoc()) {
    $labels_gen[] = $fila['estado'];
    $data_gen[] = (int)$fila['cantidad'];
}

while ($fila2 = $resultado_2->fetch_assoc()) {
    $labels_curr[] = $fila2['estado'];
    $data_curr[] = (int)$fila2['cantidad'];
}

echo json_encode([
    "labels" => $labels_gen,
    "data" => $data_gen,
    "backgroundColor" => $backgroundColor_gen,
    "labels2" => $labels_curr,
    "data2" => $data_curr,
]);

$conn->close();
?>
