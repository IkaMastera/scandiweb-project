<?php

namespace App\Classes;

require_once 'Model.php';

class Category extends Model {
    protected $table_name = "categories";

    public function read() {
        $query = "SELECT id, name FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}