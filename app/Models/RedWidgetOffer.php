<?php
declare(strict_types=1);

namespace App\Models;

class RedWidgetOffer implements OfferStrategyInterface
{
    private const TARGET_CODE = 'R01';

    public function apply(array $products): float
    {
        // Reindex the filtered array to ensure index 0 exists.
        $redWidgets = array_values(array_filter($products, function($p) {
            return $p->getCode() === self::TARGET_CODE;
        }));

        $discount = 0.0;
        $count = count($redWidgets);
        if ($count >= 2) {
            // For every pair of red widgets, discount half the price of one.
            // Since $redWidgets is re-indexed, $redWidgets[0] is now valid.
            $discount = floor($count / 2) * ($redWidgets[0]->getPrice() / 2);
        }
        return $discount;
    }
}
