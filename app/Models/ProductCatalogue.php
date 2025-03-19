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

    /**
     * Constructor loads products using a configuration array.
     *
     * @param array $productsConfig An associative array of product codes and prices.
     */
    public function __construct(array $productsConfig)
    {
        $this->products = [];
        foreach ($productsConfig as $code => $price) {
            $this->products[$code] = new Product($code, $price);
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
}
