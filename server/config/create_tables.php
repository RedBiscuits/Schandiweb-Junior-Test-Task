<?php

// DB Params
$host = 'localhost';
$db_name = 'swtask';
$username = 'root';
$password = 'j|JZZR__Qh&KJ9cm';
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
$id  = 'id';
$sku  = 'sku';
$name  = 'name';
$price  = 'price';
$product_type  = 'product_type';
$product_id  = 'product_id';
$weight  = 'weight';
$dimensions  = 'dimensions';
$size  = 'size';

// SQL queries
$sql1 = "CREATE TABLE products (
  $id  INT AUTO_INCREMENT PRIMARY KEY,
  $sku  VARCHAR(255) UNIQUE NOT NULL,
  $name  VARCHAR(255) NOT NULL,
  $price  DECIMAL(10,2) NOT NULL,
  $product_type  ENUM('book', 'furniture', 'dvd') NOT NULL
)";

$sql2 = "CREATE TABLE books (
  $id  INT AUTO_INCREMENT PRIMARY KEY,
  $product_id  INT NOT NULL,
  $weight  DECIMAL(10,2) NOT NULL,
  FOREIGN KEY ($product_id ) REFERENCES products($id )
)";

$sql3 = "CREATE TABLE furnitures (
  $id  INT AUTO_INCREMENT PRIMARY KEY,
  $product_id  INT NOT NULL,
  $width  INT NOT NULL,
  $height  INT NOT NULL,
  $length  INT NOT NULL,
  FOREIGN KEY ($product_id ) REFERENCES products($id )
)";

$sql4 = "CREATE TABLE dvds (
  $id  INT AUTO_INCREMENT PRIMARY KEY,
  $product_id  INT NOT NULL,
  $size  INT NOT NULL,
  FOREIGN KEY ($product_id ) REFERENCES products($id )
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
