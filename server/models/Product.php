<?php

/**
 * Abstract class representing a product.
 */
abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected static $host = 'localhost';
    protected static $dbName = 'swtask';
    protected static $username = 'root';
    protected static $password = '';
    
    /**
     * Abstract method to create a new product.
     *
     * @return mixed
     */
    abstract public function create();
    
    /**
     * Abstract method to read a product given its ID.
     *
     * @param int $id The product ID to read.
     * @return mixed
     */
    abstract public function read($id);
    
    /**
     * Static method to delete a product given its ID.
     *
     * @param int $id The product ID to delete.
     * @return void
     */
    public static function delete($id)
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "
            SELECT * FROM products WHERE sku = :id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $tableNames = [
                'book' => 'books',
                'furniture' => 'furnitures',
                'dvd' => 'dvds'
            ];
    
            $tableName = $tableNames[$data['product_type']];
            Product::deleteOne($data['id'], $tableName);
        } else {
            return null;
        }
    }
    
    /**
     * Static method to delete a product from its corresponding table.
     *
     * @param int $id The product ID to delete.
     * @param string $table The name of the table to delete from.
     * @return void
     */
    public static function deleteOne($id, $table)
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "DELETE FROM " . $table . " WHERE product_id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
    
    /**
     * Static method to read all products.
     *
     * @return array An array of all products.
     */
    public static function readAll()
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
            SELECT
                p.id, p.sku, p.name, p.price, p.product_type,
                b.weight,
                f.width,f.length,f.height,
                d.size
            FROM products p
            LEFT JOIN books b ON p.id = b.product_id
            LEFT JOIN furnitures f ON p.id = f.product_id
            LEFT JOIN dvds d ON p.id = d.product_id
            ORDER BY p.sku
        ";

        $stmt = $conn->prepare($query);

        // Execute query
        $stmt->execute();
        $productTypeToAttributeFunc = [
            'book' => function ($row) {
                return 'Weight: ' . $row['weight'] . ' kg';
            },
            'furniture' => function ($row) {
                return 'WxHxL: ' . $row['width'] . 'x' . $row['height'] . 'x' . $row['length'];
            },
            'dvd' => function ($row) {
                return 'Size: ' . $row['size'] . ' MB';
            },
        ];
        if ($stmt->rowCount() > 0) {
            $products = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $uniqueAttribute = '';
                
                // Get the unique attribute function for the product type
                $attributeFunc = $productTypeToAttributeFunc[$row['product_type']] ?? null;

                // Get the unique attribute string
                $uniqueAttribute = $attributeFunc !== null ? $attributeFunc($row) : null;
                $products[] = array(
                    'id' => $row['id'],
                    'sku' => $row['sku'],
                    'name' => $row['name'],
                    'price' => $row['price'] . ' $',
                    'product_type' => $row['product_type'],
                    'unique_attribute' => $uniqueAttribute
                );
            }

            return ($products);
        } else {
            return array('message' => 'No Products available');
        }
    }
    
    /**
     * Get the ID of the product.
     *
     * @return int The product ID.
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set the ID of the product.
     *
     * @param int $id The product ID.
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get the SKU of the product.
     *
     * @return string The product SKU.
     */
    public function getSku()
    {
        return $this->sku;
    }
    
    /**
     * Set the SKU of the product.
     *
     * @param string $sku The product SKU.
     * @return void
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    
    /**
     * Get the name of the product.
     *
     * @return string The product name.
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set the name of the product.
     *
     * @param string $name The product name.
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get the price of the product.
     *
     * @return float The product price.
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set the price of the product.
     *
     * @param float $price The product price.
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}