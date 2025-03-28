<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Class ProductCatalogue
 *
 * Loads and manages the product catalogue.
 */
class ProductCatalogue
{
    /**
     * @var Product[] Array of products indexed by product code.
     */
    private array $products;
    private array $productsConfig;

    /**
     * Constructor loads products using a configuration array.
     *
     */
    public function __construct()
    {
        $this->productsConfig = require __DIR__ . '/../../config/products.php';
        $this->products = [];
        foreach ($this->productsConfig as $code => $price) {
            $this->products[$code] = new Product($code, (float)$price);
        }
    }

    /**
     * Retrieve a product by its code.
     *
     * @param string $code The product code.
     * @return Product|null
     */
    public function getProduct(string $code): ?Product
    {
        return $this->products[$code] ?? null;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getProductsConfig(): array
    {
        return $this->productsConfig;
    }
}
