<?php
try {
    // Configuración de la conexión
    $host = '127.0.0.1';
    $dbname = 'miproyecto';
    $user = 'root';
    $passwordDB = '';
    $port = '3306';

    // Establecer la conexión usando PDO
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $passwordDB);
    
    // Establecer el modo de error a excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Manejar errores de conexión
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>
