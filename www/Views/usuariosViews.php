<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/usuariosModels.php";
require_once __DIR__ . "/../Controllers/usuariosController.php";

$db = Database::getConnection();
$Usuario = new UsuariosModels($db);
$ControllerUser = new usuariosController($Usuario);

// Procesar acciones
$mensaje = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($usuario && $email && $password) {
        try {
            $Usuario->añadir($usuario, $email, $password);
            $mensaje = "Usuario creado exitosamente";
        } catch (Exception $e) {
            $error = "Error al crear usuario: " . $e->getMessage();
        }
    } else {
        $error = "Todos los campos son requeridos";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['eliminar'])) {
    try {
        $ControllerUser->eliminarusuario((int)$_GET['eliminar']);
        $mensaje = "Usuario eliminado exitosamente";
    } catch (Exception $e) {
        $error = "Error al eliminar usuario: " . $e->getMessage();
    }
}

// Obtener todos los usuarios
$todosUsuarios = $ControllerUser->GetUsusuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>Gestión de Usuarios - Apicultores</title>
</head>
<body>
    <main class="container">
        <nav>
            <ul>
                <li><strong>API Apicultores</strong></li>
            </ul>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="usuariosViews.php">Usuarios</a></li>
                <li><a href="librosViews.php">Libros</a></li>
            </ul>
        </nav>

        <h1>Gestión de Usuarios</h1>

        <?php if ($mensaje): ?>
            <article style="background-color: #2d5016; color: white;">
                <?= htmlspecialchars($mensaje) ?>
            </article>
        <?php endif; ?>

        <?php if ($error): ?>
            <article style="background-color: #7d1d1d; color: white;">
                <?= htmlspecialchars($error) ?>
            </article>
        <?php endif; ?>

        <!-- Formulario para crear usuario -->
        <article>
            <h2>Crear Nuevo Usuario</h2>
            <form method="POST" action="usuariosViews.php">
                <label for="usuario">
                    Nombre de Usuario
                    <input type="text" id="usuario" name="usuario" required>
                </label>
                <label for="email">
                    Email
                    <input type="email" id="email" name="email" required>
                </label>
                <label for="password">
                    Contraseña
                    <input type="password" id="password" name="password" required>
                </label>
                <button type="submit">Crear Usuario</button>
            </form>
        </article>

        <!-- Lista de usuarios -->
        <article>
            <h2>Lista de Usuarios</h2>
            <?php if (empty($todosUsuarios)): ?>
                <p>No hay usuarios registrados</p>
            <?php else: ?>
                <table role="grid">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todosUsuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['id']) ?></td>
                                <td><?= htmlspecialchars($usuario['usuario'] ?? $usuario['nombre']) ?></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td>
                                    <a href="usuariosViews.php?eliminar=<?= $usuario['id'] ?>" 
                                       role="button" 
                                       class="secondary"
                                       onclick="return confirm('¿Está seguro de eliminar este usuario?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </article>
    </main>
</body>
</html>
