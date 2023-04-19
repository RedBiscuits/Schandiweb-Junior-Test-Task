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

    public static function read()
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name, self::$username, self::$password);
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

        if ($stmt->rowCount() > 0) {
            $products = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $unique_attribute = '';

                switch ($row['product_type']) {
                    case 'book':
                        $unique_attribute = 'Weight: ' . $row['weight'] . ' kg';
                        break;
                    case 'furniture':
                        $unique_attribute = 'WxHxL: ' . $row['width'] . 'x' . $row['height'] . 'x' . $row['length'];
                        break;
                    case 'dvd':
                        $unique_attribute = 'Size: ' . $row['size'] . ' MB';
                        break;
                }

                $products[] = array(
                    'id' => $row['id'],
                    'sku' => $row['sku'],
                    'name' => $row['name'],
                    'price' => $row['price'] . ' $',
                    'product_type' => $row['product_type'],
                    'unique_attribute' => $unique_attribute
                );
            }

            return json_encode($products);
        } else {
            return array('message' => 'No Products available');
        }
    }

    public static function delete($sku)
    {

        // initialize connection with db
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        // Get the product details based on the sku
        $sql = "SELECT id, product_type FROM products WHERE sku = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([strval($sku)]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $productId = $result['id'];
            $productType = $result['product_type'];

            // Delete the row from the respective table based on the product type
            $sql = "DELETE FROM " . $productType . "s WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$productId]);

            // Delete the row from the products table
            $sql = "DELETE FROM products WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$productId]);

            // close connection after done
            $conn = null;
        }
    }

    public static function create($request)
    {

        $productTypeMap = [
            'book' => [
                'table' => 'books',
                'columns' => ['weight'],
            ],
            'furniture' => [
                'table' => 'furnitures',
                'columns' => ['width' , 'height' , 'length'],
            ],
            'dvd' => [
                'table' => 'dvds',
                'columns' => ['size'],
            ],
        ];
        // Define the mapping between product types and their respective tables
        $pdo = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name, self::$username, self::$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert the product details into the appropriate table
        $productType = $request['optionSelected'];
        $tableDetails = $productTypeMap[$productType];
        $tableName = $tableDetails['table'];
        $columns = $tableDetails['columns'];

        // Insert the product into the products table
        $sql = "INSERT INTO products (sku, name, price, product_type)
            VALUES (:sku, :name, :price, :product_type)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':sku' => $request['sku'],
            ':name' => $request['name'],
            ':price' => $request['price'],
            ':product_type' => $request['optionSelected'],
        ]);

        // Get the product ID of the newly inserted product
        $product_id = $pdo->lastInsertId();

        $sql = "INSERT INTO $tableName (product_id, " . implode(', ', $columns) . ")
            VALUES (:product_id, " . implode(', ', array_map(function ($col) {
            return ":$col";
        }, $columns)) . ")";
        $stmt = $pdo->prepare($sql);

        $params = [':product_id' => $product_id];
        foreach ($columns as $column) {
            $params[":$column"] = $request[$column];
        }
        $stmt->execute($params);
    }
}
