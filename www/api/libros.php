<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/librosModels.php";
require_once __DIR__ . "/../Controllers/librosController.php";
require_once __DIR__ . "/../middleware/auth.php";

$db = Database::getConnection();
$Libros = new LibroModelo($db);
$ControllerUser = new librosController($Libros);
$relacion = isset($_GET["include"]) ? (string) $_GET["include"] : null;

$token = verificarToken();

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;

switch ($metodo) {
    case "GET":
        if ($id !== null && $relacion !== null) {
            $Libros = $ControllerUser->obtenerPorIdyCategoria($id, $relacion);
            
            if ($Libros && count($Libros) > 0) {
                echo json_encode($Libros);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Libro no encontrado"]);
            }
        }
        else if ($id !== null) {
            $Libros = $ControllerUser->GetLibrosById($id);

            if ($Libros) {
                echo json_encode($Libros);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Libro no encontrado"]);
            }
        } else {
            echo json_encode($ControllerUser->GetLibros());
        }

    break;
    case "DELETE":
        if ($token->rol !== 'administrador') {
            http_response_code(403);
            echo json_encode(["error" => "Acceso denegado. Solo administradores pueden eliminar libros."]);
            exit;
        } else if ($id !== null ) {
                $ControllerUser->eliminarLibro($id);
                echo json_encode(["Libro eliminado"]);
            } else {
                echo json_encode(["Introduzca un id adecuado"]);
            }
        break;

    case "PUT":
        if ($token->rol !== 'administrador') {
            http_response_code(403);
            echo json_encode(["error" => "Acceso denegado. Solo administradores pueden actualizar libros."]);
            exit;
        } else if ($id !== null) {

            $libro = $ControllerUser->GetLibrosById($id);

            if ($libro) {

                $id = $_POST['id'];
                $nuevoTitulo = $_POST['nuevoTitulo'];
                $nuevoAutor = $_POST['nuevoAutor'];
                $nuevaCategoria = $_POST['nuevaCategoria'];

                $ControllerUser->actualizarLibro();

                echo json_encode(["message" => "Libro actualizado"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Libro no encontrado"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Libro no encontrado"]);
        }
        break;
    case "POST":
        if ($token->rol !== 'administrador') {
            http_response_code(403);
            echo json_encode(["error" => "Acceso denegado. Solo administradores pueden crear libros."]);
            exit;
        } else {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $titulo = $input['titulo'] ?? null;
        $autor = $input['autor'] ?? null;
        $categoria = (int) ($input['categoria'] ?? null);
        echo json_encode(["titulo" => $titulo, "autor" => $autor, "categoria" => $categoria]);
        if ($titulo && $autor && $categoria) {
            $ControllerUser->crearLibro($titulo, $autor, $categoria);
            echo json_encode(["message" => "Libro creado"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos requeridos: titulo, autor, categoria"]);
        }
        
}
break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;
}
?>