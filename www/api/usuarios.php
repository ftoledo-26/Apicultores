<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/usuariosModels.php";



require_once __DIR__ . "/../Controllers/usuariosController.php";

$db = Database::getConnection();
$Usuario = new UsuariosModels($db);
$ControllerUser = new usuariosController($Usuario);

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;
$relacion = isset($_GET["include"]) ? (string) $_GET["include"] : null;

switch ($metodo) {
    case "GET":
        if ($id !== null && $relacion !== null) {
            $usuario = $ControllerUser->obtenerPorIdyRelacion($id, $relacion);
            
            if ($usuario && count($usuario) > 0) {
                echo json_encode($usuario);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuario no encontrado"]);
            }
        }
        else if ($id !== null) {
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
    case "PUT":

        if ($id !== null) {

            $usuario = $ControllerUser->GetUsuarioById($id);

            if ($usuario) {

                $data = json_decode(file_get_contents("php://input"), true);
                $nuevoNombre = $data['nuevoNombre'] ?? null;
                $nuevoEmail = $data['nuevoEmail'] ?? null;
                echo json_encode(["message" => "Datos recibidos", "nuevoNombre" => $nuevoNombre, "nuevoEmail" => $nuevoEmail, "id" => $id]);
                $ControllerUser->PutActualizar($nuevoNombre, $nuevoEmail, $id);
            

                echo json_encode(["message" => "Usuario actualizado"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuario no encontrado"]);
            }
        } else {
            echo json_encode(["error" => "Usuario no encontrado"]);
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
    case "POST":
        $input = json_decode(file_get_contents("php://input"), true) ?? [];
        echo json_encode($ControllerUser->crear($input));
        break;
    break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;

}
?>