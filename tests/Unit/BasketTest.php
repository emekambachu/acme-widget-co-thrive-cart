<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Basket;
use App\Models\ProductCatalogue;
use App\Models\DeliveryCalculator;
use App\Models\RedWidgetOffer;

final class BasketTest extends TestCase
{
    private ProductCatalogue $catalogue;
    private DeliveryCalculator $deliveryCalculator;
    private array $deliveryRules;

    public function setUp(): void
    {
        // Initialize the product catalogue and delivery calculator.
        $this->catalogue = new ProductCatalogue();
        $this->deliveryCalculator = new DeliveryCalculator();

        // Define delivery rules as per business requirements.
        $this->deliveryRules = [
            'under50'       => 50.00,
            'cost_under50'  => 4.95,
            'under90'       => 90.00,
            'cost_under90'  => 2.95,
            'free'          => 0.00,
        ];
    }

    public function testBasketTotalForRedWidgetPair(): void
    {
        // Create a basket instance with a red widget offer.
        $basket = new Basket($this->catalogue, [new RedWidgetOffer()], $this->deliveryCalculator);

        // Add two red widgets to trigger the offer.
        $basket->add('R01');
        $basket->add('R01');

        // Assert that the total matches the expected value.
        // For example, the expected total might be 54.37 (subject to the given rules).
        $this->assertEquals(54.37, $basket->total());
    }
}