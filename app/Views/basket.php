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
    <?php foreach ($catalogue->getProducts() as $code => $value): ?>
        <li><?= htmlspecialchars($code) ?> - $<?= number_format($value->price, 2) ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>