<?php

namespace App\Classes;

require_once 'Model.php';

class Product extends Model {
    protected $table_name = "products";

    public function read() {
        $query = "SELECT id, name, in_stock, description, category_id, brand FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}