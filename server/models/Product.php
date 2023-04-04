<?php
abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected static $host = 'localhost';
    protected static $db_name = 'swtask';
    protected static $username = 'root';
    protected static $password = '';

    abstract public function create();
    public static function read(){
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        
            $query = "
                SELECT
                    p.id, p.sku, p.name, p.price, p.product_type,
                    b.weight,
                    f.dimensions,
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
            
            if ($stmt->rowCount() > 0) {
                $products = array();
        
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $unique_attribute = '';
        
                    switch ($row['product_type']) {
                        case 'Book':
                            $unique_attribute = 'Weight: ' . $row['weight'] . ' kg';
                            break;
                        case 'Furniture':
                            $unique_attribute = 'Dimensions: ' . $row['dimensions'];
                            break;
                        case 'DVD':
                            $unique_attribute = 'Size: ' . $row['size'] . ' MB';
                            break;
                    }
        
                    $products[] = array(
                        'id' => $row['id'],
                        'sku' => $row['sku'],
                        'name' => $row['name'],
                        'price' => $row['price'],
                        'product_type' => $row['product_type'],
                        'unique_attribute' => $unique_attribute
                    );
                }
        
                return json_encode($products);
            } else {
                return array('message'=>'No Products available');
            }
    
        

        
        
    }
    abstract public function update();
    abstract public function delete();
}