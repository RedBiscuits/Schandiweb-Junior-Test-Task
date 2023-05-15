<?php

/**
 * Represents a DVD product.
 */
class DVD extends Product
{
    /**
     * The size of the DVD.
     *
     * @var int|null
     */
    private $size;

    /**
     * Constructs a new DVD instance.
     *
     * @param int|null $size The size of the DVD.
     */
    public function __construct(int $size = null)
    {
        $this->size = $size;
    }

    /**
     * Creates a new DVD product in the database.
     */
    public function create(): void
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO products (sku, name, price, product_type) VALUES (:sku, :name, :price, :product_type)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':sku', $this->sku);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':price', $this->price);
        $stmt->bindValue(':product_type', 'dvd');
        $stmt->execute();

        $id = $conn->lastInsertId();

        $query = "INSERT INTO dvds (product_id, size) VALUES (:product_id, :size)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':product_id', $id);
        $stmt->bindValue(':size', $this->size);
        $stmt->execute();
    }

    /**
     * Reads a DVD product from the database.
     *
     * @param $id The SKU of the product to read.
     * @return DVD|null The DVD product, or null if it does not exist.
     */
    public function read($id): ?DVD
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
            SELECT
                p.id, p.sku, p.name, p.price, p.product_type,
                d.size
            FROM products p
            LEFT JOIN dvds d ON p.id = d.product_id
            WHERE p.id = :id
        ";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $product = new DVD();
            $product->setId($row['id']);
            $product->setSku($row['sku']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $product->setSize($row['size']);

            return $product;
        }

        return null;
    }

    /**
     * Gets the size of the DVD.
     *
     * @return int|null The size of the DVD.
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Sets the size of the DVD.
     *
     * @param int|null $size The new size of the DVD.
     */
    public function setSize(int $size = null): void
    {
        $this->size = $size;
    }
}