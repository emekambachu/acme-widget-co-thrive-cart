<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\ProductCatalogue;
use App\Models\DeliveryCalculator;
use App\Models\Basket;
use App\Models\RedWidgetOffer;

final class BasketIntegrationTest extends TestCase
{
    /**
     * Integration test for the basket functionality.
     *
     * This test verifies that the entire basket flow works as expected:
     * - Loading the product catalogue,
     * - Applying the red widget offer,
     * - Calculating delivery charges,
     * - And returning the correct total.
     */
    public function testBasketIntegrationScenarios(): void
    {
        // Define product catalogue configuration.
        $productsConfig = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95,
        ];

        // Define delivery rules:
        // - Orders under $50 cost $4.95.
        // - Orders under $90 cost $2.95.
        // - Orders $90 or more have free delivery.
        $deliveryRules = [
            'under50'       => 50.00,
            'cost_under50'  => 4.95,
            'under90'       => 90.00,
            'cost_under90'  => 2.95,
            'free'          => 0.00,
        ];

        // Create the product catalogue instance.
        $catalogue = new ProductCatalogue($productsConfig);
        // Instantiate the delivery calculator.
        $deliveryCalculator = new DeliveryCalculator();
        // Create offer strategies array; in this case, only one offer is used.
        $offers = [new RedWidgetOffer()];

        // Scenario 1: Basket with two red widgets.
        // Expected total: According to the rules, two red widgets should trigger the red widget offer.
        // For two red widgets:
        // - Subtotal: 32.95 + 32.95 = 65.90.
        // - Discount: Half of one red widget = 32.95 / 2 ≈ 16.48.
        // - Subtotal after discount: 65.90 - 16.48 = 49.42.
        // - Delivery: Since 49.42 < 50, add $4.95.
        // - Total: 49.42 + 4.95 = 54.37.
        $basket1 = new Basket($catalogue, $offers, $deliveryCalculator, $deliveryRules);
        $basket1->add('R01');
        $basket1->add('R01');
        $this->assertEquals(54.37, $basket1->total(), "Two red widgets should total 54.37");

        // Scenario 2: Basket with a blue widget and a green widget.
        // Expected total: Blue widget ($7.95) + green widget ($24.95) = 32.90;
        // Since 32.90 < 50, delivery is $4.95.
        // Final total: 32.90 + 4.95 = 37.85.
        $basket2 = new Basket($catalogue, $offers, $deliveryCalculator, $deliveryRules);
        $basket2->add('B01');
        $basket2->add('G01');
        $this->assertEquals(37.85, $basket2->total(), "Blue and green widget should total 37.85");

        // Scenario 3: Basket with two blue widgets and three red widgets.
        // Expected total:
        // - Blue widgets: 7.95 + 7.95 = 15.90.
        // - Red widgets: 32.95 * 3 = 98.85.
        //   Offer on red widgets: Only one pair qualifies (discount = 32.95 / 2 ≈ 16.48).
        // - Subtotal: 15.90 + 98.85 = 114.75.
        // - After discount: 114.75 - 16.48 = 98.27.
        // - Delivery: 98.27 >= 90, so free delivery.
        // - Total: 98.27.
        $basket3 = new Basket($catalogue, $offers, $deliveryCalculator, $deliveryRules);
        $basket3->add('B01');
        $basket3->add('B01');
        $basket3->add('R01');
        $basket3->add('R01');
        $basket3->add('R01');
        $this->assertEquals(98.27, $basket3->total(), "Basket with two B01 and three R01 should total 98.27");
    }
}
