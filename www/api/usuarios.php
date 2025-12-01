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
$nombre = isset($_GET["nombre"]) ? (string) $_GET["nombre"] : null;

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
    
   case "PUT":

        if ($id !== null) {

            $usuario = $ControllerUser->GetUsuarioById($id);

            if ($usuario) {

                $data = json_decode(file_get_contents("php://input"), true);
                $nuevoNombre = $data['nuevoNombre'] ?? null;
                $nuevoEmail = $data['nuevoEmail'] ?? null;
                
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

    default:
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;

}
?>