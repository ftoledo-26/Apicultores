<?php
require_once __DIR__ . '/config/Database.php';
$pdo = new Database();

try {
    $connection = $pdo->getConnection();
    echo "Conexión exitosa a la base de datos.";


} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>Document</title>
</head>
<body>
    <main class="container">
        <h1>API de Apicultores</h1>
        <p>Bienvenido a la API de Apicultores. Utilice los endpoints para interactuar con los datos.</p>
        
        <article>
            <h2>Endpoints de la API</h2>
            <ul>
                <li><strong>Usuarios:</strong> /api/usuarios.php</li>
                <li><strong>Libros:</strong> /api/libros.php</li>
                <li><strong>Login:</strong> /api/login.php</li>
            </ul>
        </article>

        <article>
            <h2>Interfaces de Usuario</h2>
            <ul>
                <li><a href="/Views/usuariosViews.php">Gestión de Usuarios</a></li>
                <li><a href="/Views/librosViews.php">Gestión de Libros</a></li>
            </ul>
        </article>
        
    </main>

</body>
</html>