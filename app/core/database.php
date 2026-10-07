<?php

class Database
{
    private string $servername = "localhost";
    private string $username = "root";
    private string $password = "root";
    private string $dbname = "learn";

    public mysqli $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Koneksi Error: " . $this->conn->connect_error);
        }
    }


    public function __destruct()
    {
        $this->conn->close();
    }
};
