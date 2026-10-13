<?php

require_once(__DIR__ . "/../models/User.php");

class Database
{
    private string $servername = DB_SERVER;
    private string $username = DB_USERNAME;
    private string $password = DB_PASSWORD;
    private string $dbname = DB_NAME;

    private User $userModel;

    public mysqli $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Koneksi Error: " . $this->conn->connect_error);
        }

        $this->userModel = new User($this);

        $this->migrate();
        $this->seeder();
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    private function migrate(): void{
        $queries = [
            "CREATE TABLE IF NOT EXISTS `users` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `username` VARCHAR(50) NOT NULL UNIQUE,
              `email` VARCHAR(100) NOT NULL UNIQUE,
              `password` VARCHAR(255) NOT NULL,
              `role` VARCHAR(20) DEFAULT 'user'
            );",

            "CREATE TABLE IF NOT EXISTS `foods` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `name` VARCHAR(100) NOT NULL,
              `category` ENUM('makanan', 'minuman', 'cemilan') NOT NULL,
              `price` DECIMAL(10,2) NOT NULL,
              `description` TEXT NULL,
              `image` VARCHAR(255) NULL,
              `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );",

            "CREATE TABLE IF NOT EXISTS `orders` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `customer_name` VARCHAR(100) NOT NULL,
              `table_number` INT NOT NULL,
              `total_price` DECIMAL(10, 2) NOT NULL,
              `status` ENUM('diproses', 'pending', 'selesai') NOT NULL,
              `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );",

            "CREATE TABLE IF NOT EXISTS `order_details` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `order_id` INT NOT NULL,
              `food_id` INT NOT NULL,
              `quantity` INT NOT NULL,
              `subtotal` DECIMAL(10, 2) NOT NULL,
              `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
              FOREIGN KEY (food_id) REFERENCES foods(id) ON DELETE CASCADE
            );"
            ];

        foreach ($queries as $index => $query ) {
            $result = $this->conn->query($query);
        }
    }

    private function seeder(): void{
        $ifUserAlreadyExist = $this->userModel->findUserByEmail(email: DEFAULT_ADMIN_GMAIL);

        if (!$ifUserAlreadyExist){
        $this->userModel->create(username: DEFAULT_ADMIN_USERNAME, email: DEFAULT_ADMIN_GMAIL, password: DEFAULT_ADMIN_PASSWORD, role: "admin");
        }
    }
};
