<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Product;
use App\Models\RedWidgetOffer;

final class OfferTest extends TestCase
{
    /**
     * Test that two red widgets yield the correct discount.
     */
    public function testRedWidgetOfferWithEvenNumberOfWidgets(): void {
        // Create two red widgets, each priced at 32.95.
        $redWidget = new Product('R01', 32.95);
        $products = [$redWidget, $redWidget];

        // Instantiate the offer.
        $offer = new RedWidgetOffer();

        // Expected discount: one widget at half price = 32.95/2 = 16.475.
        // We'll round to 2 decimal places.
        $discount = $offer->apply($products);
        $this->assertEquals(16.48, round($discount, 2));
    }

    /**
     * Test that three red widgets apply the discount only to one pair.
     */
    public function testRedWidgetOfferWithOddNumberOfWidgets(): void {
        // Create three red widgets.
        $redWidget = new Product('R01', 32.95);
        $products = [$redWidget, $redWidget, $redWidget];

        // Instantiate the offer.
        $offer = new RedWidgetOffer();

        // Expected discount: only one pair qualifies for discount (16.475 rounded to 16.48).
        $discount = $offer->apply($products);
        $this->assertEquals(16.48, round($discount, 2));
    }

    /**
     * Test that when no red widgets are in the basket, no discount is applied.
     */
    public function testRedWidgetOfferWithNoWidgets(): void {
        // Empty product list.
        $products = [];
        $offer = new RedWidgetOffer();
        $discount = $offer->apply($products);
        $this->assertEquals(0.0, $discount);
    }
}
