<?php

include_once 'models/Product.php';

header('Access-Control-Allow-Methods:  POST, PUT, GET,OPTIONS');
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
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
    case '/asd/product/delete':
        // Call the delete() function from the Product class
        
        if(isset($_POST["ids"])){
            $data = $_POST["ids"];
            $x = json_decode($data);
            foreach($x as $z){
                Product::delete($z);
            }
            http_response_code(200);    
        }else{
            http_response_code(204);
        }
        break;
    default:
        // Handle invalid requests
        http_response_code(404);
        echo '404 Not Found';
        break;
}