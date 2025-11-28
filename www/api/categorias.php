<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/categoriasModels.php";
require_once __DIR__ . "/../Controllers/categoriasController.php";

$db = Database::getConnection();
$categoria = new categoriasModels($db);
$ControllerCategoria = new categoriasController($categoria);

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;

switch ($metodo) {
    case "GET":

        if ($id !== null) {
            $cate = $ControllerCategoria->ObtenerCategoriasId($id);

            if ($cate) {
                echo json_encode($cate);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuario no encontrado"]);
            }
        } else {
            echo json_encode($ControllerCategoria->ObtenerCategorias());
        }

        break;
    
   /* case "PUT":

        if ($id !== null) {
            $nombre = $_POST['nombre'];
            $nuevoNombre = $_POST['nuevoNombre'];
            $nuevoEmail = $_POST['nuevoEmail'];

            $buscar
            $ControllerUser->PutActualizar();
        }
        break;
*/
    default:
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;

}
?>