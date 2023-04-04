<?php
class Furniture extends Product
{
    private $dimensions;

    
    public function __construct($sku, $name, $price, $dimensions)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->dimensions = $dimensions;
    }

    public function create()
    {
        $conn = mysqli_connect($host, $username, $password, $db_name);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "INSERT INTO products (sku, name, price, product_type) VALUES (?, ?, ?, 'Furniture')";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssd", $this->sku, $this->name, $this->price);
            $stmt->execute();
            $this->setId($stmt->insert_id);
            $stmt->close();
        }
    
        $sql = "INSERT INTO furnitures (product_id, dimensions) VALUES (?, ?)";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("is", $this->getId(), $this->dimensions);
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
    
    //     $sql = "SELECT p.*, f.dimensions FROM products p INNER JOIN furnitures f ON p.id = f.product_id WHERE p.id = ?";
    
    //     if ($stmt = $conn->prepare($sql)) {
    //         $stmt->bind_param("i", $this->getId());
    //         $stmt->execute();
    //         $result = $stmt->get_result();
    
    //         if ($result->num_rows > 0) {
    //             $row = $result->fetch_assoc();
    //             $this->sku = $row["sku"];
    //             $this->name = $row["name"];
    //             $this->price = $row["price"];
    //             $this->dimensions = $row["dimensions"];
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
    
    //     $sql = "UPDATE furnitures SET dimensions = ? WHERE product_id = ?";
    
    //     if ($stmt = $conn->prepare($sql)) {
    //         $stmt->bind_param("si", $this->dimensions, $this->getId());
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
    
        $sql = "DELETE FROM furnitures WHERE product_id = ?";
    
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