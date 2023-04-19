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




}
