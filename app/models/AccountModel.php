<?php

class AccountModel
{
    private $conn;
    private $table_name = "account";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM account WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function save($username, $fullname, $password, $role="user")
    {
        $query = "INSERT INTO " . $this->table_name . "(username, password, fullname, role) VALUES (:username, :password, :fullname, :role)";
        $stmt = $this->conn->prepare($query);

        $fullname = htmlspecialchars(strip_tags($fullname));
        $username = htmlspecialchars(strip_tags($username));

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    public function getAccountById($id)
    {
        $query = "SELECT * FROM account WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateAccount($id, $fullname, $avatar)
    {
        $query = "UPDATE " . $this->table_name . " SET fullname = :fullname, avatar = :avatar WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $fullname = htmlspecialchars(strip_tags($fullname));
        $avatar = htmlspecialchars(strip_tags($avatar));

        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updatePassword($id, $hashedPassword)
    {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
