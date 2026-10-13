<?php

class Food
{
    public Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getFoodById(string $foodId): array|bool
    {
        $sql = "SELECT * FROM foods where id={$foodId}";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result->fetch_assoc();
    }

    public function getAllFoods(): mysqli_result|bool
    {
        $sql = "SELECT * FROM foods";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }

    public function getFoodsByCategory(string $category): mysqli_result|bool
    {
        $sql = "SELECT * FROM foods WHERE category='{$category}'";
        $result = $this->db->conn->query($sql);

        if (!$result) {
            return false;
        }

        return $result;
    }



    public function create(string $name, string $category, int $price, string|null $description, string|null $imageUrl): bool
    {
        $sql = "INSERT INTO foods (name, category, price, description, image) VALUES ('{$name}', '{$category}', {$price}, '{$description}', '{$imageUrl}')";

        $isQuerySuccess = $this->db->conn->query($sql);

        return $isQuerySuccess;
    }

    public function update(string $name, string $category, int $price, string $description, string $imageUrl, string $foodId): bool
    {
        $sql = "UPDATE foods SET name='{$name}', category='{$category}', price='{$price}', description='{$description}', image='{$imageUrl}' WHERE id={$foodId}";

        $isQuerySuccess = $this->db->conn->query($sql);

        return $isQuerySuccess;
    }


    public function delete(int $foodId): bool
    {
        $sql = "DELETE FROM foods WHERE id={$foodId}";

        $isQuerySuccess = $this->db->conn->query($sql);

        return $isQuerySuccess;
    }
}
