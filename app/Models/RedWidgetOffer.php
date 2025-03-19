<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Class RedWidgetOffer
 *
 * Implements the "buy one red widget, get the second half price" offer.
 */
class RedWidgetOffer implements OfferStrategyInterface
{
    // Constant representing the red widget product code.
    private const TARGET_CODE = 'R01';

    /**
     * Apply the offer to the given products.
     *
     * @param Product[] $products Array of products.
     * @return float Discount amount.
     */
    public function apply(array $products): float
    {
        // Filter the products for red widgets.
        $redWidgets = array_filter($products, function($p) {
            return $p->getCode() === self::TARGET_CODE;
        });

        $discount = 0.0;
        $count = count($redWidgets);
        if ($count >= 2) {
            // For every pair of red widgets, apply half-price discount on one.
            // Note: Assumes that all red widgets have the same price.
            $discount = floor($count / 2) * ($redWidgets[0]->getPrice() / 2);
        }
        return $discount;
    }
}
