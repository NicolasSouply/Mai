<?php

use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
    public function testGetTotalPrice()
    {
        $item = new OrderItem("Plat 1", 10.0, 2);
        $this->assertEquals(20.0, $item->getTotalPrice());
    }
}
