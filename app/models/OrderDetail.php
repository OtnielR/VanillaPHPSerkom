<?php

class OrderDetail
{
    public Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getOrderDetailsByOrderId(int $orderId): mysqli_result|bool
    {
        $sql = "SELECT * FROM order_details INNER JOIN foods ON order_details.food_id = foods.id WHERE order_id={$orderId}";

        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }



    public function create(int $orderId, int $foodId, int $quantity, float $subtotal): bool
    {
        $sql = "INSERT INTO order_details (order_id, food_id, quantity, subtotal) VALUE ({$orderId}, {$foodId}, {$quantity}, {$subtotal})";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return true;
    }
}
