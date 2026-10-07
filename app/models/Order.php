<?php

class Order
{

    public Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(string $customerName, string $tableNumber, int $totalPrice): bool
    {
        $sql = "INSERT INTO orders (customer_name, table_number, total_price, status) VALUE ('$customerName', '$tableNumber', $totalPrice, 'pending')";
        $isQuerySuccess = $this->db->conn->query($sql);

        print_r($isQuerySuccess);

        if ($isQuerySuccess) {
            return true;
        }

        return false;
    }

    public function getAllOrders(): mysqli_result|bool
    {
        $sql = "SELECT * FROM orders";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }
    public function getAllPendingOrders(): mysqli_result|bool
    {
        $sql = "SELECT * FROM orders WHERE status='pending'";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }
    public function getAllOngoingOrders(): mysqli_result|bool
    {
        $sql = "SELECT * FROM orders WHERE status='diproses'";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }

    public function getAllCompleteOrders(): mysqli_result|bool
    {
        $sql = "SELECT * FROM orders WHERE status='selesai'";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }
}
