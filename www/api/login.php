<?php
header("Content-Type: application/json; charset=utf-8");

require __DIR__ ."../../vendor/autoload.php";
require __DIR__ ."../../config/config.php";
require __DIR__ ."../../config/Database.php";
require __DIR__ . "../../Controllers/usuariosController.php";
require __DIR__ ."../../Models/usuariosModels.php";

use Firebase\JWT\JWT;

$db = Database::getConnection();
$user = new UsuariosModels($db);
$usuarios = new usuariosController($user);

// Verificar método HTTP
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido, usa POST"]);
    exit;
}

// Obtener JSON del body
$input = json_decode(file_get_contents("php://input"), true) ?? [];

$email = $input['email'] ?? "";
$password = $input['contrasenia'] ?? "";

echo json_encode(["INPUT" => $input]);
echo json_encode(var_dump("EMAIL:", $email));
echo json_encode(var_dump("PASSWORD:", $password));
exit;

// Buscar usuario por email
$usuarioDB = $usuarios->ObtenerDatos("email", $email);

if(!$usuarioDB){
    http_response_code(401);
    echo json_encode(["error" => "Email no encontrado"]);
    exit;
}

// Validar contraseña
if($password !== $usuarioDB["contrasenia"]){
    http_response_code(401);
    echo json_encode(["error" => "Contraseña incorrecta"]);
    exit;
}

// Generar token
$payload = [
    "id"    => $usuarioDB['id'],
    "email" => $usuarioDB['email'],
    "rol"   => 'administrador',
    "iat"   => time(),
    "exp"   => time() + 3600
];
$token = JWT::encode($payload, JWT_SECRET, 'HS256');

echo json_encode([
    "payload" => $payload,
    "secret" => JWT_SECRET,
    "token" => $token
]);
exit;

?>