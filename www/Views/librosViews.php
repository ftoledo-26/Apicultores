<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/librosModels.php";
require_once __DIR__ . "/../Controllers/librosController.php";

$db = Database::getConnection();
$Libros = new LibroModelo($db);
$ControllerLibros = new librosController($Libros);

// Procesar acciones
$mensaje = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST['accion'] ?? '';
    
    if ($accion === 'crear') {
        $titulo = $_POST['titulo'] ?? '';
        $autor = $_POST['autor'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        
        if ($titulo && $autor && $categoria) {
            try {
                $ControllerLibros->crearLibro($titulo, $autor, (int)$categoria);
                $mensaje = "Libro creado exitosamente";
            } catch (Exception $e) {
                $error = "Error al crear libro: " . $e->getMessage();
            }
        } else {
            $error = "Todos los campos son requeridos";
        }
    }
    
    if ($accion === 'editar') {
        $_POST['id'] = $_POST['editId'] ?? '';
        $_POST['nuevoTitulo'] = $_POST['titulo'] ?? '';
        $_POST['nuevoAutor'] = $_POST['autor'] ?? '';
        $_POST['nuevaCategoria'] = $_POST['categoria'] ?? '';
        
        try {
            $ControllerLibros->actualizarLibro();
            $mensaje = "Libro actualizado exitosamente";
        } catch (Exception $e) {
            $error = "Error al actualizar libro: " . $e->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['eliminar'])) {
    try {
        $ControllerLibros->eliminarLibro((int)$_GET['eliminar']);
        $mensaje = "Libro eliminado exitosamente";
    } catch (Exception $e) {
        $error = "Error al eliminar libro: " . $e->getMessage();
    }
}

// Obtener libro para editar si se solicita
$libroEditar = null;
if (isset($_GET['editar'])) {
    $libroEditar = $ControllerLibros->GetLibrosById((int)$_GET['editar']);
}

// Obtener todos los libros
$todosLibros = $ControllerLibros->GetLibros();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>Gestión de Libros - Apicultores</title>
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

        <h1>Gestión de Libros</h1>

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

        <!-- Formulario para crear/editar libro -->
        <article>
            <h2><?= $libroEditar ? 'Editar Libro' : 'Agregar Nuevo Libro' ?></h2>
            <form method="POST" action="librosViews.php">
                <input type="hidden" name="accion" value="<?= $libroEditar ? 'editar' : 'crear' ?>">
                <?php if ($libroEditar): ?>
                    <input type="hidden" name="editId" value="<?= htmlspecialchars($libroEditar['id']) ?>">
                <?php endif; ?>
                
                <label for="titulo">
                    Título
                    <input type="text" id="titulo" name="titulo" 
                           value="<?= $libroEditar ? htmlspecialchars($libroEditar['titulo']) : '' ?>" required>
                </label>
                <label for="autor">
                    Autor
                    <input type="text" id="autor" name="autor" 
                           value="<?= $libroEditar ? htmlspecialchars($libroEditar['autor']) : '' ?>" required>
                </label>
                <label for="categoria">
                    Categoría (ID)
                    <input type="number" id="categoria" name="categoria" 
                           value="<?= $libroEditar ? htmlspecialchars($libroEditar['categoria_id'] ?? $libroEditar['categoria']) : '' ?>" required>
                </label>
                <button type="submit"><?= $libroEditar ? 'Guardar Cambios' : 'Agregar Libro' ?></button>
                <?php if ($libroEditar): ?>
                    <a href="librosViews.php" role="button" class="secondary">Cancelar</a>
                <?php endif; ?>
            </form>
        </article>

        <!-- Lista de libros -->
        <article>
            <h2>Catálogo de Libros</h2>
            <?php if (empty($todosLibros)): ?>
                <p>No hay libros registrados</p>
            <?php else: ?>
                <table role="grid">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todosLibros as $libro): ?>
                            <tr>
                                <td><?= htmlspecialchars($libro['id']) ?></td>
                                <td><?= htmlspecialchars($libro['titulo']) ?></td>
                                <td><?= htmlspecialchars($libro['autor']) ?></td>
                                <td><?= htmlspecialchars($libro['categoria_id'] ?? $libro['categoria'] ?? '') ?></td>
                                <td>
                                    <a href="librosViews.php?editar=<?= $libro['id'] ?>" role="button" class="contrast">Editar</a>
                                    <a href="librosViews.php?eliminar=<?= $libro['id'] ?>" 
                                       role="button" 
                                       class="secondary"
                                       onclick="return confirm('¿Está seguro de eliminar este libro?')">Eliminar</a>
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
