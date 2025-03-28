<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Class DeliveryCalculator
 *
 * Calculates the delivery charge based on basket subtotal.
 */
class DeliveryCalculator
{
    private array $deliveryRules;
    public function __construct()
    {
        $this->deliveryRules = require __DIR__ . '/../../config/delivery.php';
    }

    /**
     * Calculate the delivery fee based on the subtotal and configured rules.
     *
     * @param float $subtotal The subtotal after discounts.
     * @param array $rules    The delivery rules configuration.
     * @return float          Delivery charge.
     */
    public function calculate(float $subtotal, array $rules): float
    {
        // Rules:
        // - If subtotal is less than 'under50', delivery costs 'cost_under50'.
        // - If subtotal is less than 'under90', delivery costs 'cost_under90'.
        // - Otherwise, delivery is free.
        if ($subtotal < $rules['under50']) {
            return $rules['cost_under50'];
        }

        if ($subtotal < $rules['under90']) {
            return $rules['cost_under90'];
        }
        return $rules['free'];
    }

    public function getDeliveryRules(): array
    {
        return $this->deliveryRules;
    }
}
