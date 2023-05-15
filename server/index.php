<?php

// Include the necessary model classes
include_once 'models/Product.php';
include_once 'models/Book.php';
include_once 'models/Furniture.php';
include_once 'models/DVD.php';

// Set headers to allow cross-origin requests from any origin
header('Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS');

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day 
}

// Handle OPTIONS requests for CORS preflight checks
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    exit(0);
}

// Get the requested URL
$request = $_SERVER['REQUEST_URI'];

// Define a mapping of product types to their corresponding classes and constructor arguments
$classMap = [
    'book' => ['class' => 'Book', 'args' => ['weight']],
    'furniture' => ['class' => 'Furniture', 'args' => ['width', 'length', 'height']],
    'dvd' => ['class' => 'DVD', 'args' => ['size']],
    'product' => ['class' => 'Product', 'args' => []],
];

// Define a mapping of request URLs to their corresponding request handlers
$requestHandlers = [
    '/' => function () {
        echo 'Welcome to my API';
    },
    '/asd/product/read' => function () {
        $result = Product::readAll();
        echo json_encode($result);
    },
    '/asd/product/create' => function () use ($classMap) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the product type from the request payload or default to 'product'
            $data = json_decode(file_get_contents('php://input'), true);
            $product_type = $data['optionSelected'] ?? 'product';

            // Create a new product object of the appropriate type
            $typeInfo = $classMap[$product_type] ?? $classMap['product'];
            $product = new $typeInfo['class'](...array_intersect_key($data, array_flip($typeInfo['args'])));

            // Set the product properties from the request payload
            $product->setSku($data['sku']);
            $product->setName($data['name']);
            $product->setPrice($data['price']);

            // Save the product to the database and return the result
            $result = $product->create();
            http_response_code(200);
            echo $result;
        } else {
            // Return a 'Method Not Allowed' error if the request method is not POST
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit();
        }
    },
    '/asd/product/delete' => function () {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['ids'])) {
                // Delete the products with the given IDs and return a success response
                $ids = json_decode($_POST['ids'], true) ?? null;
                if ($ids) {
                    foreach ($ids as $id) {
                        Product::delete($id);
                    }
                    http_response_code(200);
                } else {
                    // Return a 'Bad Request' error if the request payload is empty or malformed
                    http_response_code(400);
                }
            } else {
                // Return a 'No Content' response if the request payload is missing
                http_response_code(204);
            }
        } else {
            // Return a 'Method Not Allowed' error if the request method is not POST
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit();
        }
    },
];

// Get the appropriate request handler based on the requested URL or return a 'Not Found' error
$requestHandler = $requestHandlers[$request] ?? function () {
    http_response_code(404);
    echo '404 Not Found';
};

// Call the request handler
$requestHandler();