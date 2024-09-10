<?php
// conexion.php
$host = 'localhost';
$db = 'auditoria';
$user = 'root';
$password = 'root';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>


