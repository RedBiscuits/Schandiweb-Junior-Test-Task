<?php
class DVD extends Product
{
    private $size;

    
    public function __construct($sku, $name, $price, $size)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->size = $size;
    }

    public function create()
{
    $conn = mysqli_connect($host, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO products (sku, name, price, product_type) VALUES (?, ?, ?, 'DVD')";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssd", $this->sku, $this->name, $this->price);
        $stmt->execute();
        $this->setId($stmt->insert_id);
        $stmt->close();
    }

    $sql = "INSERT INTO dvds (product_id, size) VALUES (?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $this->getId(), $this->size);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
}

// public function read()
// {
//     $conn = mysqli_connect($host, $username, $password, $db_name);

//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     $sql = "SELECT p.*, d.size FROM products p INNER JOIN dvds d ON p.id = d.product_id WHERE p.id = ?";

//     if ($stmt = $conn->prepare($sql)) {
//         $stmt->bind_param("i", $this->getId());
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result->num_rows > 0) {
//             $row = $result->fetch_assoc();
//             $this->sku = $row["sku"];
//             $this->name = $row["name"];
//             $this->price = $row["price"];
//             $this->size = $row["size"];
//         }

//         $stmt->close();
//     }

//     $conn->close();
// }

// public function update()
// {
//     $conn = mysqli_connect($host, $username, $password, $db_name);

//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     $sql = "UPDATE products SET sku = ?, name = ?, price = ? WHERE id = ?";

//     if ($stmt = $conn->prepare($sql)) {
//         $stmt->bind_param("ssdi", $this->sku, $this->name, $this->price, $this->getId());
//         $stmt->execute();
//         $stmt->close();
//     }

//     $sql = "UPDATE dvds SET size = ? WHERE product_id = ?";

//     if ($stmt = $conn->prepare($sql)) {
//         $stmt->bind_param("ii", $this->size, $this->getId());
//         $stmt->execute();
//         $stmt->close();
//     }

//     $conn->close();
// }

public function delete()
{
    $conn = mysqli_connect($host, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM dvds WHERE product_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        $stmt->close();
    }

    $sql = "DELETE FROM products WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
}
}