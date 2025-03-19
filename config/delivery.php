<?php
// Returns an array of delivery charge thresholds and fees.
return [
    'under50'       => 50.00,  // Threshold for highest delivery fee.
    'cost_under50'  => 4.95,   // Delivery fee if subtotal is below $50.
    'under90'       => 90.00,  // Next threshold.
    'cost_under90'  => 2.95,   // Delivery fee if subtotal is below $90.
    'free'          => 0.00,   // Free delivery for subtotals of $90 or more.
];
