<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/usuariosModels.php";

// Verificar que la clase existe
if (!class_exists('UsuariosModels')) {
    die('Error: UsuariosModels class not loaded. File path: ' . __DIR__ . '/../Models/usuariosModels.php');
}

require_once __DIR__ . "/../Controllers/usuariosController.php";

$db = Database::getConnection();
$Usuario = new UsuariosModels($db);
$ControllerUser = new usuariosController($Usuario);

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;
$nombre = isset($_GET["nombre"]) ? (int) $_GET["nombre"] : null;

switch ($metodo) {
    case "GET":

        if ($id !== null) {
            $usuario = $ControllerUser->GetUsuarioById($id);

            if ($usuario) {
                echo json_encode($usuario);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuario no encontrado"]);
            }
        } else {
            echo json_encode($ControllerUser->GetUsusuarios());
        }

        break;
    case "DELETE":
        if ($id !== null ) {
                $ControllerUser->eliminarusuario($id);
                echo json_encode(["Usuario eliminado"]);
            } else {
                echo json_encode(["Introduzca un id adecuado"]);
            }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;
}
?>