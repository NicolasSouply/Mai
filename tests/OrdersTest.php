<?php

use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    private Orders $order;

    protected function setUp(): void
    {
        // Créer une instance de la classe Orders avant chaque test
        $this->order = new Orders('pending', 0.0, new DateTime(), new DateTime());
    }

    public function testAddItem(): void
    {
        $item = new OrderItem('Pizza', 10.0, 1);
        $this->order->addItem($item);

        $this->assertCount(1, $this->order->getItems());
        $this->assertEquals(10.0, $this->order->getTotalPrice());
    }

    public function testRemoveItem(): void
    {
        $item1 = new OrderItem('Pizza', 10.0, 1);
        $item2 = new OrderItem('Pasta', 8.0, 1);
        $this->order->addItem($item1);
        $this->order->addItem($item2);

        $this->order->removeItem($item1);
        $this->assertCount(1, $this->order->getItems());
        $this->assertEquals(8.0, $this->order->getTotalPrice());
    }

    public function testUpdateTotalPrice(): void
    {
        $item1 = new OrderItem('Pizza', 10.0, 2); // Total: 20.0
        $item2 = new OrderItem('Pasta', 8.0, 1); // Total: 8.0
        $this->order->addItem($item1);
        $this->order->addItem($item2);

        $this->assertEquals(28.0, $this->order->getTotalPrice());
    }

    public function testTotalPriceWithZeroItems(): void
    {
        $this->assertEquals(0.0, $this->order->getTotalPrice());
    }

    public function testAddItemWithZeroQuantity(): void
    {
        $item = new OrderItem('Pizza', 10.0, 0); // Total: 0.0
        $this->order->addItem($item);

        $this->assertCount(1, $this->order->getItems());
        $this->assertEquals(0.0, $this->order->getTotalPrice());
    }

    public function testRemoveItemNotInOrder(): void
    {
        $item1 = new OrderItem('Pizza', 10.0, 1);
        $item2 = new OrderItem('Pasta', 8.0, 1);
        $this->order->addItem($item1);
        
        $this->order->removeItem($item2); // Suppression d'un item non présent
        $this->assertCount(1, $this->order->getItems());
        $this->assertEquals(10.0, $this->order->getTotalPrice());
    }
}
