<?php

namespace App\Controller;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;
use App\Classes\Database;
use App\Classes\Category;
use App\Classes\Product;
use App\Classes\Attribute;
use App\Classes\Price;

class GraphQL {
    public static function handle() {
        try {
            $db = (new Database())->getConnection();

            $categoryType = new ObjectType([
                'name' => 'Category',
                'fields' => [
                    'id' => Type::id(),
                    'name' => Type::string(),
                ],
            ]);

            $attributeType = new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'id' => Type::id(),
                    'product_id' => Type::id(),
                    'attribute_name' => Type::string(),
                    'attribute_value' => Type::string(),
                ],
            ]);

            $priceType = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'id' => Type::id(),
                    'product_id' => Type::id(),
                    'amount' => Type::float(),
                    'currency_label' => Type::string(),
                    'currency_symbol' => Type::string(),
                ],
            ]);

            $productType = new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::id(),
                    'name' => Type::string(),
                    'in_stock' => Type::boolean(),
                    'description' => Type::string(),
                    'category_id' => Type::id(),
                    'brand' => Type::string(),
                    'attributes' => [
                        'type' => Type::listOf($attributeType),
                        'resolve' => function($product, $args, $context) use ($db) {
                            $attribute = new Attribute($db);
                            $stmt = $attribute->readByProductId($product['id']);
                            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                        }
                    ],
                    'prices' => [
                        'type' => Type::listOf($priceType),
                        'resolve' => function($product, $args, $context) use ($db) {
                            $price = new Price($db);
                            $stmt = $price->readByProductId($product['id']);
                            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                        }
                    ],
                ],
            ]);

            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'categories' => [
                        'type' => Type::listOf($categoryType),
                        'resolve' => function () use ($db) {
                            $category = new Category($db);
                            $stmt = $category->read();
                            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                        }
                    ],
                    'products' => [
                        'type' => Type::listOf($productType),
                        'resolve' => function () use ($db) {
                            $product = new Product($db);
                            $stmt = $product->read();
                            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                        }
                    ],
                ],
            ]);

            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'createOrder' => [
                        'type' => Type::string(),
                        'args' => [
                            'productIds' => Type::listOf(Type::id()),
                        ],
                        'resolve' => function ($root, $args) use ($db) {
                            // Implement order creation logic here
                            return "Order created successfully";
                        }
                    ],
                ],
            ]);

            $schema = new Schema(
                (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
            );

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            $result = GraphQLBase::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
    }
}