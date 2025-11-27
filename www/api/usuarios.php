<?php
header("Content-Type: application/json; charset=utf-8");
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__) . "/config/config.php";
require_once dirname(__DIR__) . "/config/Database.php";
require_once dirname(__DIR__) . "/Models/usuariosModels.php";
require_once dirname(__DIR__) . "/Controllers/usuariosController.php";

$db = Database::getConnection();
$Usuario = new UsuariosModels($db);
$ControllerUser = new usuariosController($Usuario);

$metodo = $_SERVER["REQUEST_METHOD"];

$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;

switch ($metodo) {
    case "GET":
        // GET /empleados.php  → listar empleados
        echo json_encode($ControllerUser->GetUsusuarios());
        break;
 default:
        // Método no permitido
        http_response_code(405);
        echo json_encode(["error" => "Solo GET, POST, PUT y DELETE"]);
        break;
}
?>