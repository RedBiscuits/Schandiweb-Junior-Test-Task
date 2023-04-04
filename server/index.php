<?php

include_once 'models/Product.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        // Default route
        echo 'Welcome to my API';
        break;

    case '/asd/product/read':
        // Call the read() function from the Product class
        $result = Product::read();
        echo ($result);
        break;
    default:
        // Handle invalid requests
        http_response_code(404);
        echo '404 Not Found';
        break;
}