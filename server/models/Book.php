<?php

/**
 * Represents a book product.
 */
class Book extends Product
{
    /**
     * The weight of the book.
     *
     * @var float|null
     */
    private $weight;

    /**
     * Constructs a new Book instance.
     *
     * @param float|null $weight The weight of the book.
     */
    public function __construct(float $weight = null)
    {
        $this->weight = $weight;
    }

    /**
     * Creates a new book product in the database.
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
        $stmt->bindValue(':product_type', 'book');
        $stmt->execute();

        $id = $conn->lastInsertId();

        $query = "INSERT INTO books (product_id, weight) VALUES (:product_id, :weight)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':product_id', $id);
        $stmt->bindValue(':weight', $this->weight);
        $stmt->execute();
    }

    /**
     * Reads a book product from the database.
     *
     * @param $id The SKU of the product to read.
     * @return Book|null The book product, or null if it does not exist.
     */
    public function read($id): ?Book
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
            SELECT
                p.id, p.sku, p.name, p.price, p.product_type,
                b.weight
            FROM products p
            LEFT JOIN books b ON p.id = b.product_id
            WHERE p.id = :id
        ";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $product = new Book();
            $product->setId($row['id']);
            $product->setSku($row['sku']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $product->setWeight($row['weight']);

            return $product;
        }

        return null;
    }

    /**
     * Gets the weight of the book.
     *
     * @return float|null The weight of the book.
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * Sets the weight of the book.
     *
     * @param float|null $weight The new weight of the book.
     */
    public function setWeight(float $weight = null): void
    {
        $this->weight = $weight;
    }
}