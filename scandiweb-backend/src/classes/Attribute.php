<?php

namespace App\Classes;

class Attribute extends Model {
    public function readByProductId($productId) {
        $query = "SELECT id, product_id, attribute_name, attribute_value FROM attributes WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt;
    }
}