<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/comentariosModels.php";
require_once __DIR__ . "/../Controllers/comentariosController.php";

$db = Database::getConnection();
$Comentarios = new comentarios($db);
$ControllerUser = new controladorComentarios($Comentarios);

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;

switch ($metodo) {
    case "GET":

        if ($id !== null) {
            $coments = $ControllerUser->GetComentarioUserId($id);

            if ($coments) {
                echo json_encode($coments);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Comentario no encontrado"]);
            }
        } else {
            echo json_encode($ControllerUser->GetComentario());
        }

        break;
    
    case "DELETE":
        if ($id !== null ) {
                $ControllerUser->eliminarComentario($id);
                echo json_encode(["Comentario eliminado"]);
            } else {
                echo json_encode(["Introduzca un id adecuado"]);
            }
        break;

    
        case "PUT":

        

        if ($id !== null) {

            $coments = $ControllerUser->GetComentarioUserId($id);

            if ($coments) {
            $data = json_decode(file_get_contents("php://input"), true);
            $comentario = $data['comentario'] ?? null;

            $ControllerUser->PutComentario($comentario, $id);

            echo json_encode(["message" => "Comentario actualizado"]);
            }else{
                http_response_code(404);
                echo json_encode(["error" => "Comentario no encontrado"]);
            }
            
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;

}
?>