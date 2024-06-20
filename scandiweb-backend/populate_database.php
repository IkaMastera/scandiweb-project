<?php

require_once 'src/Classes/Database.php';
require_once 'src/Classes/Product.php';
require_once 'src/Classes/Category.php';
require_once 'src/Classes/Attribute.php';
require_once 'src/Classes/Price.php';

use App\Classes\Database;
use App\Classes\Product;
use App\Classes\Category;
use App\Classes\Attribute;
use App\Classes\Price;

// Create a new database connection
$db = new Database();
$conn = $db->getConnection();

if ($conn === null) {
    die("Connection failed: Unable to establish a connection to the database.");
}

// Clear existing data
$conn->query("DELETE FROM attributes");
$conn->query("DELETE FROM prices");
$conn->query("DELETE FROM products");
$conn->query("DELETE FROM categories");

// Load data from JSON file
$json = file_get_contents('data.json');
$data = json_decode($json, true);

// Insert categories
$category = new Category($conn);
foreach ($data['data']['categories'] as $category_data) {
    $category->create($category_data['name']);
}

// Get the category ID mapping
$category_ids = [];
$result = $conn->query("SELECT id, name FROM categories");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $category_ids[$row['name']] = $row['id'];
}

// Insert products
$product = new Product($conn);
$attribute = new Attribute($conn);
$price = new Price($conn);

foreach ($data['data']['products'] as $product_data) {
    $gallery_json = json_encode($product_data['gallery']);
    $category_id = $category_ids[$product_data['category']];
    $product->create(
        $product_data['id'],
        $product_data['name'],
        $product_data['inStock'],
        $gallery_json,
        $product_data['description'],
        $category_id,
        $product_data['brand']
    );

    // Insert attributes
    foreach ($product_data['attributes'] as $attribute_data) {
        foreach ($attribute_data['items'] as $item) {
            $attribute->create(
                $product_data['id'],
                $attribute_data['name'],
                $item['value']
            );
        }
    }

    // Insert prices
    foreach ($product_data['prices'] as $price_data) {
        $price->create(
            $product_data['id'],
            $price_data['amount'],
            $price_data['currency']['label'],
            $price_data['currency']['symbol']
        );
    }
}

echo "Database populated successfully.";
?>