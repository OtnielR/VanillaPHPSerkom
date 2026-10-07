<?php

class User
{
    public Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllUsers(): mysqli_result|bool
    {
        $sqlQuery = "SELECT * FROM user";
        $result = $this->db->conn->query($sqlQuery);


        if (!$result) {
            return false;
        }

        return $result;
    }

    public function findUserByEmail(string $email): array|bool
    {
        $sqlQuery = "SELECT * FROM user WHERE email='$email'";
        $result = $this->db->conn->query($sqlQuery);

        $user = $result->fetch_assoc();

        if (!$user) {
            return false;
        }

        return $user;
    }

    public function create(string $username, string $email, string $password, string $role): void
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $sqlQuery = "INSERT INTO user (username, email, password, role) VALUE ('$username', '$email', '$hashPassword', '$role')";

        $isQuerySuccess = $this->db->conn->query($sqlQuery);
    }

    public function delete(int $userId): bool
    {
        $sqlQuery = "DELETE FROM user WHERE id={$userId}";

        $isQuerySuccess = $this->db->conn->query($sqlQuery);

        return $isQuerySuccess;
    }
}
