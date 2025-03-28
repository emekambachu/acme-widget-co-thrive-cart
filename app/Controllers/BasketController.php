<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Basket;
use App\Models\DeliveryCalculator;
use App\Models\ProductCatalogue;

/**
 * Class BasketController
 *
 * Handles user interactions with the basket.
 */
class BasketController
{
    private Basket $basket;
    private ProductCatalogue $catalogue;
    private DeliveryCalculator $delivery;
    private array $offersConfig;

    /**
     * Constructor receives the Basket via dependency injection.
     *
     * @param Basket $basket
     */
    public function __construct(Basket $basket, ProductCatalogue $catalogue, DeliveryCalculator $delivery, array $offersConfig)
    {
        $this->basket = $basket;
        $this->catalogue = $catalogue;
        $this->delivery = $delivery;
        $this->offersConfig = $offersConfig;
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
        // Create offer instances.
        $offers = [];
        foreach ($this->offersConfig as $offerClass) {
            $offers[] = new $offerClass();
        }

        // Retrieve basket items from session or initialize as an empty array.
        if (!isset($_SESSION['basket_items'])) {
            $_SESSION['basket_items'] = [];
        }

        // If a new product is submitted via POST, update the session.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_code'])) {
            $newProduct = strtoupper(trim($_POST['product_code']));
            // Optionally validate that the product exists in the catalogue.
            if ($this->catalogue->getProduct($newProduct) !== null) {
                $_SESSION['basket_items'][] = $newProduct;
            }
            // Redirect to avoid form resubmission.
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

        // Create a new basket and populate it with product codes from the session.
        $basket = new Basket($this->catalogue, $offers, $this->delivery);
        foreach ($_SESSION['basket_items'] as $code) {
            $basket->add($code);
        }

        // If user wants to clear the basket.
        if (isset($_GET['clear']) && $_GET['clear'] === '1') {
            $_SESSION['basket_items'] = [];
            // Reinitialize basket after clearing.
            $basket = new Basket($this->catalogue, $offers, $this->delivery);
        }

        $catalogue = $this->catalogue;

        include __DIR__ . '/../Views/basket.php';
    }
}
