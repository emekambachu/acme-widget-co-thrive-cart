<?php
declare(strict_types=1);

// Autoload classes using Composer.
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\BasketController;
use App\Models\ProductCatalogue;
use App\Models\DeliveryCalculator;
use App\Models\Basket;
use App\Models\RedWidgetOffer;

// Load configuration files.
$products = require __DIR__ . '/../config/products.php';
$delivery = require __DIR__ . '/../config/delivery.php';
$offersConfig = require __DIR__ . '/../config/offers.php';

// Set up the product catalogue.
$catalogue = new ProductCatalogue($products);

// Instantiate the delivery calculator.
$deliveryCalculator = new DeliveryCalculator();

// Create offer instances.
$offers = [];
foreach ($offersConfig as $offerClass) {
    $offers[] = new $offerClass();
}

// Create the basket with its dependencies.
$basket = new Basket($catalogue, $offers, $deliveryCalculator, $delivery);

// Create the controller.
$controller = new BasketController($basket);

// Example usage: add products to the basket.
$controller->addProduct('R01');  // Add first red widget.
$controller->addProduct('R01');  // Add second red widget (this triggers the offer).
$controller->addProduct('G01');  // Add a green widget.

// Render the basket view.
$controller->showBasket();
