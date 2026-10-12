<?php

class Order
{

    public Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(string $customerName, string $tableNumber, int $totalPrice): bool|int
    {
        $sql = "INSERT INTO orders (customer_name, table_number, total_price, status) VALUE ('$customerName', '$tableNumber', $totalPrice, 'pending')";
        $isQuerySuccess = $this->db->conn->query($sql);

        print_r($isQuerySuccess);

        if ($isQuerySuccess) {
            $orderId = $this->db->conn->insert_id;
            return $orderId;
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

    public function update(int $orderId, string $status)
    {
        $sql = "UPDATE orders SET status='{$status}' WHERE id={$orderId}";

        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }
}
