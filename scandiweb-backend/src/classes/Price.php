<?php

namespace App\Classes;

require_once 'Model.php';

class Price extends Model {
    protected $table_name = "prices";

    public function readByProductId($product_id) {
        $query = "SELECT id, product_id, amount, currency_label, currency_symbol FROM " . $this->table_name . " WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $product_id);
        $stmt->execute();
        return $stmt;
    }

    public function create($product_id, $amount, $currency_label, $currency_symbol) {
        $query = "INSERT INTO " . $this->table_name . " (product_id, amount, currency_label, currency_symbol) VALUES (:product_id, :amount, :currency_label, :currency_symbol)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':currency_label', $currency_label);
        $stmt->bindParam(':currency_symbol', $currency_symbol);
        return $stmt->execute();
    }
}