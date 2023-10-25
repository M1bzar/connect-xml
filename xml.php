<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'gael', '123', 'blog');

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'agregarDatos') {
            // Recuperar los datos enviados en la solicitud POST
            $title = $_POST['title'];
            $description = $_POST['description'];
            $fecha = $_POST['fecha'];
            $type = $_POST['type'];

            // Realizar la inserción en la base de datos
            $query = "INSERT INTO targetas (title, description, fecha, type) VALUES ('$title', '$description', '$fecha', '$type')";
            if ($conexion->query($query) === TRUE) {
                echo json_encode(array('message' => 'Datos insertados correctamente.'));
            } else {
                echo json_encode(array('error' => 'Error al insertar datos: ' . $conexion->error));
            }
        } elseif ($_POST['accion'] === 'obtenerDatos') {
            // Realizar la consulta a la base de datos y devolver los datos existentes
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
            echo json_encode($data);
        } elseif ($_POST['accion'] === 'eliminarDatos') {
            // Recuperar el ID de los datos a eliminar
            $id = $_POST['id'];

            // Realizar la eliminación en la base de datos
            $query = "DELETE FROM targetas WHERE id = $id";
            if ($conexion->query($query) === TRUE) {
                echo json_encode(array('message' => 'Datos eliminados correctamente.'));
            } else {
                echo json_encode(array('error' => 'Error al eliminar datos: ' . $conexion->error));
            }
        }elseif ($_POST['accion'] === 'actualizarDatos') {
            $id = $_POST['updateId'];
            $newTitle = $_POST['newTitle'];
            $newDescription = $_POST['newDescription'];
            $newFecha = $_POST['newFecha'];
            $newType = $_POST['newType'];

            // Realizar la actualización en la base de datos
            $query = "UPDATE targetas SET title = '$newTitle', description = '$newDescription', fecha = '$newFecha', type = '$newType' WHERE id = $id";
            if ($conexion->query($query) === TRUE) {
                echo json_encode(array('message' => 'Datos actualizados correctamente.'));
            } else {
                echo json_encode(array('error' => 'Error al actualizar datos: ' . $conexion->error));
            }
        }
    }
        
    
} else {
    // Manejar otros tipos de solicitudes, si es necesario
    // ...
}
