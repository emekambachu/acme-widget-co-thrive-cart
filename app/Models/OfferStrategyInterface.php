<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Interface OfferStrategyInterface
 *
 * Defines a strategy for applying special offers.
 */
interface OfferStrategyInterface
{
    /**
     * Applies the offer to a list of products.
     *
     * @param Product[] $products Array of products in the basket.
     * @return float The discount amount to subtract.
     */
    public function apply(array $products): float;
}
