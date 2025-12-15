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
$relacion = isset($_GET["relacion"]) ? $_GET["relacion"] : null;
$me = isset($_GET["me"]) ? $_GET["me"] : null;


switch ($metodo) {
    case "GET":
        if($me !== null){
            echo json_encode($datosToken);
            exit;
        }
        else if ($id !== null && $relacion !== null) {
            $usuario = $ControllerUser->obtenerPorIdyRelacion($id, $relacion);
            
            if ($usuario) {
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
        if ($datosToken->rol !== 'administrador') {
            http_response_code(403);
            echo json_encode(["error" => "Acceso denegado. Solo administradores pueden actualizar usuarios."]);
            exit;
        } else if ($id !== null) {

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
            if ($datosToken->rol !== 'administrador') {
                http_response_code(403);
                echo json_encode(["error" => "Acceso denegado. Solo administradores pueden eliminar usuarios."]);
                exit;
            } else if ($id !== null ) {
                $ControllerUser->eliminarusuario($id);
                echo json_encode(["Usuario eliminado"]);
            } else {
                echo json_encode(["Introduzca un id adecuado"]);
            }
        break;
    case "POST":
        if ($datosToken->rol !== 'administrador') {
            http_response_code(403);
            echo json_encode(["error" => "Acceso denegado. Solo administradores pueden crear usuarios."]);
            exit;
        } else {
        $data = json_decode(file_get_contents("php://input"), true);
            if($data){
                $nombre = $data['nombre'] ?? null;
                $email = $data['email'] ?? null;
                $contrasenia = $data['contrasenia'] ?? null;
                $rol = $data['rol'] ?? 'usuario';
                $user = $ControllerUser->ObtenerDatos($data['email']);
                if($user){
                    http_response_code(400);
                    echo json_encode("Usuario ya existente");
                    exit();
                }
                $nuevoId = $ControllerUser->crear([
                    'nombre' => $nombre,
                    'email' => $email,
                    'contrasenia' => $contrasenia,
                    'rol' => $rol
                ]);
                
                
                http_response_code(201);
                echo json_encode(["message" => "Usuario creado", "id" => $nuevoId]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Datos inválidos"]);
            }
        }
        
    break;
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;

}
?>