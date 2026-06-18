<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
    private $secretKey;
    private $algorithm = "HS256";
    private $expiration;

    public function __construct($expiration = 3600)
    {
        $this->secretKey = "your-secret-key-change-in-production";
        $this->expiration = $expiration;
    }

    public function generateToken($userId, $username, $role)
    {
        $now = time();
        $payload = [
            "iss" => "store-api",
            "iat" => $now,
            "exp" => $now + $this->expiration,
            "user_id" => $userId,
            "username" => $username,
            "role" => $role,
        ];

        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, $this->algorithm));
            return (array) $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getTokenFromHeader()
    {
        $header = $_SERVER["HTTP_AUTHORIZATION"] ?? "";
        if (preg_match("/Bearer\s+(.+)$/i", $header, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function authenticate()
    {
        $token = $this->getTokenFromHeader();
        if (!$token) {
            http_response_code(401);
            echo json_encode(["error" => "Token not provided"]);
            exit;
        }

        $payload = $this->validateToken($token);
        if (!$payload) {
            http_response_code(401);
            echo json_encode(["error" => "Invalid or expired token"]);
            exit;
        }

        return $payload;
    }

    public function authorize($allowedRoles)
    {
        $payload = $this->authenticate();
        if (!in_array($payload["role"], (array) $allowedRoles)) {
            http_response_code(403);
            echo json_encode(["error" => "Insufficient permissions"]);
            exit;
        }
        return $payload;
    }
}
