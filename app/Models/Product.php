<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Class Product
 *
 * Represents a product offered by Acme Widget Co.
 */
class Product
{
    // Unique product code (e.g., R01, G01, B01).
    private string $code;
    // Price of the product.
    private float $price;

    /**
     * Constructor to initialize the product.
     *
     * @param string $code  The product code.
     * @param float  $price The product price.
     */
    public function __construct(string $code, float $price)
    {
        $this->code  = $code;
        $this->price = $price;
    }

    /**
     * Get the product code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get the product price.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
