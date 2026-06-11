<?php
require_once "app/config/database.php";
require_once "app/models/AccountModel.php";
require_once "app/utils/JWTHandler.php";

class AccountApiController
{
    private $accountModel;
    private $db;
    private $jwt;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwt = new JWTHandler();
        header("Content-Type: application/json");
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON"]);
            return;
        }

        $username = $data["username"] ?? "";
        $password = $data["password"] ?? "";

        if (empty($username) || empty($password)) {
            http_response_code(422);
            echo json_encode(["error" => "Username and password are required"]);
            return;
        }

        $account = $this->accountModel->getAccountByUsername($username);
        if (!$account) {
            http_response_code(401);
            echo json_encode(["error" => "Invalid username or password"]);
            return;
        }

        if (!password_verify($password, $account->password)) {
            http_response_code(401);
            echo json_encode(["error" => "Invalid username or password"]);
            return;
        }

        $token = $this->jwt->generateToken($account->id, $account->username, $account->role);

        echo json_encode([
            "message" => "Login successful",
            "token" => $token,
            "user" => [
                "id" => $account->id,
                "username" => $account->username,
                "fullname" => $account->fullname,
                "role" => $account->role,
            ],
        ]);
    }
}
