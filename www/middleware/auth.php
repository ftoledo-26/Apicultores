<?php
include __DIR__ . "/../vendor/autoload.php";


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verificarToken() : object|null{

    $headers = getallheaders();

    $authHeader = null;
    foreach ($headers as $k => $v) {
        if (strtolower($k) === 'authorization') {
            $authHeader = $v;
            break;
        }
    }

    if (!$authHeader) {
        return null;
    }

    $token = str_replace("Bearer ", "", $authHeader);

    try {
        $data = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
        return $data;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido o expirado"]);
        error_log($e->getMessage());
        exit;
    }
}