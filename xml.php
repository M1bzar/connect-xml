<?php

header("Access-Control-Allow-Origin: *"); // Permite a cualquier dominio acceder
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'gael', '123', 'xml');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Realizar la consulta a la base de datos
$query = "SELECT * FROM ejemplo";
$resultado = $conexion->query($query);

// Generar el XML
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?><data>';

while ($fila = $resultado->fetch_assoc()) {
    echo '<item>';
    foreach ($fila as $campo => $valor) {
        echo '<' . $campo . '>' . $valor . '</' . $campo . '>';
    }
    echo '</item>';
}

echo '</data>';

// Cerrar la conexión a la base de datos
$conexion->close();
?>