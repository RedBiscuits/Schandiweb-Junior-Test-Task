<?php

/**
 * Represents a furniture product.
 */
class Furniture extends Product
{
    private $width;
    private $length;
    private $height;

    /**
     * Constructs a new Furniture instance.
     *
     * @param float|null $width The width of the furniture.
     * @param float|null $length The length of the furniture.
     * @param float|null $height The height of the furniture.
     */
    public function __construct(float $width = null, float $length = null, float $height = null)
    {
        $this->width = $width;
        $this->length = $length;
        $this->height = $height;
    }

    /**
     * Creates a new furniture product in the database.
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
        $stmt->bindValue(':product_type', 'furniture');
        $stmt->execute();

        $id = $conn->lastInsertId();

        $query = "INSERT INTO furnitures (product_id, width, length, height) VALUES (:product_id, :width, :length, :height)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':product_id', $id);
        $stmt->bindValue(':width', $this->width);
        $stmt->bindValue(':length', $this->length);
        $stmt->bindValue(':height', $this->height);
        $stmt->execute();
    }

    /**
     * Reads a furniture product from the database.
     *
     * @param $id The SKU of the product to read.
     * @return Furniture|null The furniture product, or null if it does not exist.
     */
    public function read($id): ?Furniture
    {
        $conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT p.id, p.sku, p.name, p.price, p.product_type, f.width, f.length, f.height FROM products p LEFT JOIN furnitures f ON p.id = f.product_id WHERE p.id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $product = new Furniture();
            $product->setId($row['id']);
            $product->setSku($row['sku']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $product->setWidth($row['width']);
            $product->setLength($row['length']);
            $product->setHeight($row['height']);

            return $product;
        }

        return null;
    }

    /**
     * Gets the width of the furniture.
     *
     * @return float|null The width of the furniture.
     */
    public function getWidth(): ?float
    {
        return $this->width;
    }

    /**
     * Sets the width of the furniture.
     *
     * @param float|null $width The new width of the furniture.
     */
    public function setWidth(float $width = null): void
    {
        $this->width = $width;
    }

    /**
     * Gets the length of the furniture.
     *
     * @return float|null The length of the furniture.
     */
    public function getLength(): ?float
    {
        return $this->length;
    }

    /**
     * Sets the length of the furniture.
     *
     * @param float|null $length The new length of the furniture.
     */
    public function setLength(float $length = null): void
    {
        $this->length = $length;
    }

    /**
     * Gets the height of the furniture.
     *
     * @return float|null The height of the furniture.
     */
    public function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * Sets the height of the furniture.
     *
     * @param float|null $height The new height of the furniture.
     */
    public function setHeight(float $height = null): void
    {
        $this->height = $height;
    }
}