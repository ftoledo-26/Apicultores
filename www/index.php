<?php
require_once __DIR__ . '/Database.php';
$pdo = new Database();

try {
    $connection = $pdo->getConnection();
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}