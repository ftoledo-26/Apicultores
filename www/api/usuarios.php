<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/usuariosModels.php";
require_once __DIR__ . "/../Controllers/usuariosController.php";
require_once __DIR__ . "/../vendor/autoload.php";
include __DIR__ . "/../middleware/auth.php";

$datosToken = verificarToken();
use Firebase\JWT\JWT;

$db = Database::getConnection();
$Usuario = new UsuariosModels($db);
$ControllerUser = new usuariosController($Usuario);

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;
<<<<<<< HEAD


switch ($metodo) {
    case "GET":
        if($datosToken->rol !== 'asd'){
            http_response_code(403);
            echo json_encode(["error" => "Acceso denegado"]);
            exit;
=======
$nombre = isset($_GET["nombre"]) ? (string) $_GET["nombre"] : null;
$page = isset($_GET["page"]) ? (int) $_GET["page"] : null;
$limit = isset($_GET["limit"]) ? (int) $_GET["limit"] : null; 

switch ($metodo) {
    case "GET":

        if ($limit !== null && $page !== null) {

            $usuariosPaginados = $ControllerUser->GetUsuariosPaginados($limit, $page);
            if($usuariosPaginados){
                http_response_code(200);
                echo json_encode($usuariosPaginados);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "No hay usuarios en esta página"]);
                exit;
            }
>>>>>>> 154dc7b9be973b54b801382f15d8611af19254df
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
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $id = $ControllerUser->crear($data);

            $payload = [
                "id"    => $id,
                "email" => $data['email'],
                "rol"   => 'administrador',
                "iat"   => time(),
                "exp"   => time() + 3600
            ];
            $token = JWT::encode($payload, JWT_SECRET, 'HS256');
            echo json_encode(["token" => $token]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios"]);
        }
    break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;

}
?>