<?php

// DB Params
$host = 'localhost';
$db_name = 'swtask';
$username = 'root';
$password = '';
$conn;

// Create connection
$conn = null;

try { 
    $conn = mysqli_connect($host, $username, $password, $db_name);
} catch(PDOException $e) {
    echo 'Connection Error: ' . $e->getMessage();
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define column names as variables
$id_col = 'id';
$sku_col = 'sku';
$name_col = 'name';
$price_col = 'price';
$product_type_col = 'product_type';
$product_id_col = 'product_id';
$weight_col = 'weight';
$dimensions_col = 'dimensions';
$size_col = 'size';

// SQL queries
$sql1 = "CREATE TABLE products (
  $id_col INT AUTO_INCREMENT PRIMARY KEY,
  $sku_col VARCHAR(255) UNIQUE NOT NULL,
  $name_col VARCHAR(255) NOT NULL,
  $price_col DECIMAL(10,2) NOT NULL,
  $product_type_col ENUM('book', 'furniture', 'dvd') NOT NULL
)";

$sql2 = "CREATE TABLE books (
  $id_col INT AUTO_INCREMENT PRIMARY KEY,
  $product_id_col INT NOT NULL,
  $weight_col DECIMAL(10,2) NOT NULL,
  FOREIGN KEY ($product_id_col) REFERENCES products($id_col)
)";

$sql3 = "CREATE TABLE furnitures (
  $id_col INT AUTO_INCREMENT PRIMARY KEY,
  $product_id_col INT NOT NULL,
  $dimensions_col VARCHAR(255) NOT NULL,
  FOREIGN KEY ($product_id_col) REFERENCES products($id_col)
)";

$sql4 = "CREATE TABLE dvds (
  $id_col INT AUTO_INCREMENT PRIMARY KEY,
  $product_id_col INT NOT NULL,
  $size_col INT NOT NULL,
  FOREIGN KEY ($product_id_col) REFERENCES products($id_col)
)";

// Execute queries
if (mysqli_query($conn, $sql1)) {
    echo "Table products created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}

if (mysqli_query($conn, $sql2)) {
    echo "Table books created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}

if (mysqli_query($conn, $sql3)) {
    echo "Table furnitures created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}

if (mysqli_query($conn, $sql4)) {
    echo "Table dvds created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}

mysqli_close($conn);
?>