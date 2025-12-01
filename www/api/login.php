<?php
header("Content-Type: application/json; charset=utf-8");

require __DIR__ ."../../vendor/autoload.php";
require __DIR__ ."../../config/config.php";
require __DIR__ ."../../config/Database.php";
require __DIR__ . "../../Controllers/usuariosController.php";
require __DIR__ ."../../Models/usuariosModels.php";

use Firebase\JWT\JWT;
$db = Database :: getConnection();
$user = new UsuariosModels($db);
$usuaios = new usuariosController($user);

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo json_encode(["error" => "Metodo no permitido, Usa POST"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"),true)?? [];

$email = $input['email'] ?? "";
$password = $input['password'] ?? "";


if($email == $usuaios->ObtenerDatos('email', $email) 
        && $password == $usuaios->ObtenerDatos('password', $email)){
    http_response_code(401); 
    echo json_encode(["error" => "Credenciales incorrectas"]);
    exit;    
}
$payload = [
    "id"   => 1,                    
    "email" => $email,
    "rol" => 'administrador',         
    "iat"   => time(),                
    "exp"   => time() + 3600,         
];

$token = JWT::encode($payload, JWT_SECRET, 'HS256');
http_response_code(200);
echo json_encode(["token" => $token,]);

?>