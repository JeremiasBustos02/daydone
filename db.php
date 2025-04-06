<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'daydone';
$username = 'root'; // Usuario por defecto en XAMPP
$password = ''; // Contraseña vacía por defecto de XAMPP

try {
    // Se crea una nueva conexion PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Se configura PDO para que lance excepciones en caso de error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Manejo de errores
    die("Error de conexión: " . $e->getMessage());
}
?>