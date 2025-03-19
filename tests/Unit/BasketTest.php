<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Basket;
use App\Models\ProductCatalogue;
use App\Models\DeliveryCalculator;
use App\Models\RedWidgetOffer;

final class BasketTest extends TestCase
{
    public function testBasketTotalForRedWidgetPair(): void
    {
        // Define a test product configuration.
        $productsConfig = ['R01' => 32.95, 'G01' => 24.95, 'B01' => 7.95];
        $catalogue = new ProductCatalogue($productsConfig);

        // Define delivery rules as per business requirements.
        $deliveryRules = [
            'under50'       => 50.00,
            'cost_under50'  => 4.95,
            'under90'       => 90.00,
            'cost_under90'  => 2.95,
            'free'          => 0.00,
        ];

        // Create a basket instance with a red widget offer.
        $basket = new Basket($catalogue, [new RedWidgetOffer()], new DeliveryCalculator(), $deliveryRules);

        // Add two red widgets to trigger the offer.
        $basket->add('R01');
        $basket->add('R01');

        // Assert that the total matches the expected value.
        // For example, the expected total might be 54.37 (subject to the given rules).
        $this->assertEquals(54.37, $basket->total());
    }
}
