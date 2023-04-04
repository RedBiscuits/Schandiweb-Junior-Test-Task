<?php
//
class Book extends Product
{
    private $weight;
    private $host = 'localhost';
    private $db_name = 'swtask';
    private $username = 'root';
    private $password = '';
    
    public function __construct($sku, $name, $price, $weight)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight;
    }
    
    public function create()
    {
        $conn = mysqli_connect($host, $username, $password, $db_name);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "INSERT INTO products (sku, name, price, product_type) VALUES (?, ?, ?, 'Book')";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssd", $this->sku, $this->name, $this->price);
            $stmt->execute();
            $this->setId($stmt->insert_id);
            $stmt->close();
        }
    
        $sql = "INSERT INTO books (product_id, weight) VALUES (?, ?)";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("id", $this->id, $this->weight);
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
    
    //     $sql = "SELECT p.*, b.weight FROM products p INNER JOIN books b ON p.id = b.product_id WHERE p.id = ?";
    
    //     if ($stmt = $conn->prepare($sql)) {
    //         $stmt->bind_param("i", $this->getId());
    //         $stmt->execute();
    //         $result = $stmt->get_result();
    
    //         if ($result->num_rows > 0) {
    //             $row = $result->fetch_assoc();
    //             $this->sku = $row["sku"];
    //             $this->name = $row["name"];
    //             $this->price = $row["price"];
    //             $this->weight = $row["weight"];
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
    
    //     $sql = "UPDATE books SET weight = ? WHERE product_id = ?";
    
    //     if ($stmt = $conn->prepare($sql)) {
    //         $stmt->bind_param("di", $this->weight, $this->getId());
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
    
        $sql = "DELETE FROM books WHERE product_id = ?";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
            $stmt->close();
        }
    
        $sql = "DELETE FROM products WHERE id = ?";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
            $stmt->close();
        }
    
        $conn->close();
    }
}
