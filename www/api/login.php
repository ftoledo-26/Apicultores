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
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true) ?? [];

$email    = trim($input['email'] ?? '');
$password = $input['contrasenia'] ?? '';

if ($email === '' || $password === '') {
    http_response_code(400);
    echo json_encode(["error" => "Email y contraseña son obligatorios"]);
    exit;
}


$usuarioDB = $usuarios->ObtenerDatos($email);

if (!$usuarioDB) {
    http_response_code(401);
    echo json_encode(["error" => "Email no encontrado"]);
    exit;
}
$hashBD = $usuarioDB['contrasenia'];

if (!str_starts_with($hashBD, '$2y$')) {
    if ($password !== $hashBD) {
        http_response_code(401);
        echo json_encode(["error" => "Contraseña incorrecta"]);
        exit;
    }
} 
else {
    if (!password_verify($password, $hashBD)) {
        http_response_code(401);
        echo json_encode(["error" => "Contraseña incorrecta"]);
        exit;
    }
}
//echo json_encode(["message" => "Autenticación exitosa $password"]); // Se elimina esta línea para no enviar una respuesta prematura
$payload = [
    "id"    => $usuarioDB['id'],
    "email" => $usuarioDB['email'],
    "rol"   => $usuarioDB['rol'],
    "iat"   => time(),
    "exp"   => time() + 3600
];

$token = JWT::encode($payload, JWT_SECRET, 'HS256');

echo json_encode([
    "token" => $token
]);
exit;