<?php

namespace App\Classes;

require_once 'Model.php';

class Attribute extends Model {
    protected $table_name = "attributes";

    public function readByProductId($product_id) {
        $query = "SELECT id, product_id, attribute_name, attribute_value FROM " . $this->table_name . " WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $product_id);
        $stmt->execute();
        return $stmt;
    }

    public function create($product_id, $attribute_name, $attribute_value) {
        $query = "INSERT INTO " . $this->table_name . " (product_id, attribute_name, attribute_value) VALUES (:product_id, :attribute_name, :attribute_value)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':attribute_name', $attribute_name);
        $stmt->bindParam(':attribute_value', $attribute_value);
        return $stmt->execute();
    }
}