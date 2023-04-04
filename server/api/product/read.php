<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../models/Product.php';

    // product query
    $result = Product::read();

    return $result;
