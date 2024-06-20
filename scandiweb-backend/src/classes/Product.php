<?php

namespace App\Classes;

require_once 'Model.php';

class Product extends Model {
    protected $table_name = "products";

    public function read() {
        $query = "SELECT id, name, in_stock, gallery, description, category_id, brand FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($id, $name, $in_stock, $gallery, $description, $category_id, $brand) {
        $query = "INSERT INTO " . $this->table_name . " (id, name, in_stock, gallery, description, category_id, brand) VALUES (:id, :name, :in_stock, :gallery, :description, :category_id, :brand)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':in_stock', $in_stock, \PDO::PARAM_BOOL);
        $stmt->bindParam(':gallery', $gallery);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':brand', $brand);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}