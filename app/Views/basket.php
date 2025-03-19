<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Basket Summary</title>
</head>
<body>
<h1>Your Basket</h1>
<ul>
    <?php
    // Loop through each product in the basket and display its code and price.
    foreach ($this->basket->getItems() as $item): ?>
        <li><?= htmlspecialchars($item->getCode()) ?> - $<?= number_format($item->getPrice(), 2) ?></li>
    <?php endforeach; ?>
</ul>
<h2>Total: $<?= number_format($total, 2) ?></h2>
</body>
</html>
