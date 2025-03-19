<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Basket;

/**
 * Class BasketController
 *
 * Handles user interactions with the basket.
 */
class BasketController
{
    private Basket $basket;

    /**
     * Constructor receives the Basket via dependency injection.
     *
     * @param Basket $basket
     */
    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    /**
     * Add a product to the basket.
     *
     * @param string $code The product code.
     */
    public function addProduct(string $code): void
    {
        $this->basket->add($code);
    }

    /**
     * Render the basket view to display the basket details.
     */
    public function showBasket(): void
    {
        $total = $this->basket->total();
        // Pass basket data to the view.
        include __DIR__ . '/../Views/basket.php';
    }
}
