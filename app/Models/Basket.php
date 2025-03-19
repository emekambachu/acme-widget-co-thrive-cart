<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Class Basket
 *
 * Represents a shopping basket that contains products, applies offers, and calculates totals.
 */
class Basket
{
    /**
     * @var Product[] List of products added to the basket.
     */
    private array $items = [];
    private ProductCatalogue $catalogue;
    /** @var OfferStrategyInterface[] */
    private array $offers;
    private DeliveryCalculator $deliveryCalculator;
    private array $deliveryRules;

    /**
     * Basket constructor.
     *
     * @param ProductCatalogue         $catalogue          The product catalogue.
     * @param OfferStrategyInterface[] $offers             Array of offer strategies.
     * @param DeliveryCalculator       $deliveryCalculator The delivery calculator.
     * @param array                    $deliveryRules      Delivery charge rules.
     */
    public function __construct(
        ProductCatalogue $catalogue,
        array $offers,
        DeliveryCalculator $deliveryCalculator,
        array $deliveryRules
    ) {
        $this->catalogue          = $catalogue;
        $this->offers             = $offers;
        $this->deliveryCalculator = $deliveryCalculator;
        $this->deliveryRules      = $deliveryRules;
    }

    /**
     * Add a product to the basket by its product code.
     *
     * @param string $productCode
     */
    public function add(string $productCode): void
    {
        $product = $this->catalogue->getProduct($productCode);
        if ($product !== null) {
            $this->items[] = $product;
        }
    }

    /**
     * Calculate the total cost of the basket.
     *
     * This method applies any offers to reduce the subtotal,
     * then adds the appropriate delivery fee.
     *
     * @return float Final total rounded to 2 decimal places.
     */
    public function total(): float
    {
        // Calculate subtotal by summing prices of all products.
        $subtotal = array_reduce($this->items, function (float $carry, Product $item) {
            return $carry + $item->getPrice();
        }, 0.0);

        // Calculate total discount from all offer strategies.
        $totalDiscount = 0.0;
        foreach ($this->offers as $offer) {
            $totalDiscount += $offer->apply($this->items);
        }

        // Subtract discount from subtotal.
        $subtotalAfterDiscount = $subtotal - $totalDiscount;

        // Calculate delivery charge based on the adjusted subtotal.
        $delivery = $this->deliveryCalculator->calculate($subtotalAfterDiscount, $this->deliveryRules);

        // Return the final total (subtotal after discount + delivery fee).
        return round($subtotalAfterDiscount + $delivery, 2);
    }

    /**
     * Get all items in the basket.
     *
     * @return Product[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
