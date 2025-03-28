<?php
declare(strict_types=1);

session_start();

// Autoload classes using Composer.
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\BasketController;
use App\Models\DeliveryCalculator;
use App\Models\ProductCatalogue;
use App\Models\Basket;

// Load configuration files.
$offersConfig = require __DIR__ . '/../config/offers.php';
$catalogue = new ProductCatalogue();
$deliveryCalculator = new DeliveryCalculator();
$basket = new Basket($catalogue, $offersConfig, $deliveryCalculator);

$basketController = new BasketController(
    $basket,
    $catalogue,
    $deliveryCalculator,
    $offersConfig
);

$basketController->showBasket();
?>