<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'gael', '123', 'blog');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Realizar la consulta a la base de datos
$query = "SELECT * FROM targetas";
$resultado = $conexion->query($query);

// Crear un arreglo para almacenar los datos
$data = array();

while ($fila = $resultado->fetch_assoc()) {
    $data[] = $fila;
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Convertir los datos en JSON
$jsonData = json_encode($data);

// Configurar la cabecera para indicar que se está enviando JSON
header('Content-Type: application/json');

// Imprimir los datos en formato JSON
echo $jsonData;
?>
