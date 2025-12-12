<?php
header("Content-Type: application/json; charset=utf-8");

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../config/Database.php";
require __DIR__ . "/../Models/usuariosModels.php";
require __DIR__ . "/../Controllers/usuariosController.php";
require __DIR__ . "/../vendor/autoload.php";

use Firebase\JWT\JWT;

$db = Database::getConnection();
$model = new UsuariosModels($db);
$usuarios = new usuariosController($model);


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido, usa POST"]);
    exit;
}


$input = json_decode(file_get_contents("php://input"), true) ?? [];
$email = $input['email'] ?? "";
$password = $input['contrasenia'] ?? "";

if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(["error" => "Email y contraseña son obligatorios"]);
    exit;
}


$usuarioDB = $usuarios->ObtenerDatos("email", $email);

if (!$usuarioDB) {
    http_response_code(404);
    echo json_encode(["error" => "Email no encontrado"]);
    exit;
}

if ($password !== $usuarioDB['contrasenia']) {
    http_response_code(401);
    echo json_encode(["error" => "Contraseña incorrecta"]);
    exit;
}


$payload = [
    "id"    => $usuarioDB['id'],
    "email" => $usuarioDB['email'],
    "rol"   => 'administrador',// addministrador o usuario
    "iat"   => time(),
    "exp"   => time() + 3600
];

$token = JWT::encode($payload, JWT_SECRET, 'HS256');

echo json_encode([
    "token" => $token
]);

exit;
?>
