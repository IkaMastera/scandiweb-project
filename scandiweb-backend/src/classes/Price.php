<?php

namespace App\Classes;

require_once 'Model.php';

class Price extends Model {
    protected $table_name = "prices";

    public function readByProductId($productId) {
        $query = "SELECT id, product_id, amount, currency_label, currency_symbol FROM " . $this->table_name . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt;
    }
}