<?php
// Inlcuimos la conexion a la base de datos
require_once 'db.php';

// Establecemos los encabezados para que la API pueda ser consumida
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        listarTareas($db);
        break;
    case 'POST':
        crearTarea($db);
        break;
    default:
        echo json_encode(['message' => 'Método no soportado']);
        break;
}

function listarTareas($db) {
    $stmt = $db->query("SELECT * FROM tarea");
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tareas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

function crearTarea($db) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        isset($data['title'], $data['description'], $data['status'],
        $data['expiration_date'], $data['priority'])
    ){
        $sql = "INSERT INTO tarea (title, description, status, creation_date, expiration_date, priority) 
                VALUES (:title, :description, :status, NOW(), :expiration_date, :priority)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':status' => $data['status'],
            ':expiration_date' => $data['expiration_date'],
            ':priority' => $data['priority']
        ]);

        echo json_encode(['message' => 'Tarea creada con éxito']);
    } else {
        echo json_encode(['error' => 'Datos incompletos']);
    }

}


?>