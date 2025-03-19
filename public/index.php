<?php
declare(strict_types=1);

session_start();

// Autoload classes using Composer.
require __DIR__ . '/../vendor/autoload.php';

use App\Models\ProductCatalogue;
use App\Models\DeliveryCalculator;
use App\Models\Basket;

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

// Retrieve basket items from session or initialize as an empty array.
if (!isset($_SESSION['basket_items'])) {
    $_SESSION['basket_items'] = [];
}

// If a new product is submitted via POST, update the session.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_code'])) {
    $newProduct = strtoupper(trim($_POST['product_code']));
    // Optionally validate that the product exists in the catalogue.
    if ($catalogue->getProduct($newProduct) !== null) {
        $_SESSION['basket_items'][] = $newProduct;
    }
    // Redirect to avoid form resubmission.
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Create a new basket and populate it with product codes from the session.
$basket = new Basket($catalogue, $offers, $deliveryCalculator, $delivery);
foreach ($_SESSION['basket_items'] as $code) {
    $basket->add($code);
}

// If user wants to clear the basket.
if (isset($_GET['clear']) && $_GET['clear'] === '1') {
    $_SESSION['basket_items'] = [];
    // Reinitialize basket after clearing.
    $basket = new Basket($catalogue, $offers, $deliveryCalculator, $delivery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Acme Widget Co - Basket</title>
</head>
<body>
<h1>Your Basket</h1>

<!-- Display basket items -->
<?php if (!empty($basket->getItems())): ?>
    <ul>
        <?php foreach ($basket->getItems() as $item): ?>
            <li><?= htmlspecialchars($item->getCode()) ?> - $<?= number_format($item->getPrice(), 2) ?></li>
        <?php endforeach; ?>
    </ul>
    <h2>Total: $<?= number_format($basket->total(), 2) ?></h2>
<?php else: ?>
    <p>Your basket is empty.</p>
<?php endif; ?>

<!-- Form to add a new product -->
<h3>Add a Product</h3>
<form method="post" action="">
    <label for="product_code">Product Code:</label>
    <input type="text" name="product_code" id="product_code" required placeholder="e.g., R01">
    <button type="submit">Add to Basket</button>
</form>

<!-- Button to clear the basket -->
<form method="get" action="" style="margin-top:20px;">
    <button type="submit" name="clear" value="1">Clear Basket</button>
</form>

<!-- Display available products for user convenience -->
<h3>Available Products</h3>
<ul>
    <?php foreach ($products as $code => $price): ?>
        <li><?= htmlspecialchars($code) ?> - $<?= number_format($price, 2) ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>
