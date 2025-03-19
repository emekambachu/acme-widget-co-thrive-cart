<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Product;

final class ProductTest extends TestCase
{
    /**
     * Test that the product getters return the expected values.
     */
    public function testProductGetters(): void {
        // Create a product with a known code and price.
        $product = new Product('R01', 32.95);

        // Verify that the getters return the correct values.
        $this->assertEquals('R01', $product->getCode());
        $this->assertEquals(32.95, $product->getPrice());
    }
}
