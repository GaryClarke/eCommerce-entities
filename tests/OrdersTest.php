<?php

namespace App\Tests;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;

class OrdersTest extends DatabaseDependantTestCase
{

    private string $deliveryName = 'Ringo Starr';
    private string $deliveryAddress = '44 Penny Lane, Liverpool';

    protected function setUp(): void
    {
        parent::setUp();

        $order = new Order();
        $order->setDeliveryName($this->deliveryName);
        $order->setDeliveryAddress($this->deliveryAddress);

        // DO SOMETHING
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }


    /** @test */
    public function an_order_can_be_created()
    {
        // MAKE ASSERTIONS
        $this->assertDatabaseHasEntity(Order::class, [
                'deliveryName'    => $this->deliveryName,
                'deliveryAddress' => $this->deliveryAddress,
                'cancelledAt'     => null,
            ]
        );
    }


    /** @test */
    public function an_order_can_be_updated()
    {
        // SETUP
        /** @var Order $order */
        $order = $this->entityManager->getRepository(Order::class)->findOneBy([
            'deliveryName' => $this->deliveryName
        ]);

        $newAddress = '9 Newcastle Avenue, Liverpool';

        // DO SOMETHING
        $order->setDeliveryAddress($newAddress);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // MAKE ASSERTIONS
        $this->assertDatabaseHasEntity(Order::class, [
                'deliveryName'    => $this->deliveryName,
                'deliveryAddress' => $newAddress
            ]
        );

        $this->assertDatabaseNotHas(Order::class, [
                'deliveryName'    => $this->deliveryName,
                'deliveryAddress' => $this->deliveryAddress
            ]
        );
    }

    /** @test */
    public function an_order_can_be_cancelled()
    {
        // SETUP
        /** @var Order $order */
        $order = $this->entityManager->getRepository(Order::class)->findOneBy([
            'deliveryName' => $this->deliveryName
        ]);

        $cancelledAt = new \DateTimeImmutable();

        // DO SOMETHING
        $order->setCancelledAt($cancelledAt);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // MAKE ASSERTIONS
        $this->assertDatabaseHasEntity(Order::class, [
                'deliveryName'    => $this->deliveryName,
                'deliveryAddress' => $this->deliveryAddress,
                'cancelledAt'     => $cancelledAt
            ]
        );
    }

    /** @test */
    public function an_item_can_be_added_to_an_order()
    {
        // SETUP
        // Need a product
        $name = 'Roland TD-07KV V-Drum Electronic Drum Kit BUNDLE';
        $description = 'Conveniently compact and ideal for drumming at home, the TD-07KV V-Drums kit delivers the superior expression and playability of high-end V-Drums in a budget-friendly package. ';

        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice(94400);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        // Need an order
        $order = $this->entityManager->getRepository(Order::class)->findOneBy([
            'deliveryName' => $this->deliveryName
        ]);

        // DO SOMETHING
        // Create an item using refs to the order and product
        $item = new Item();
        $item->setOrder($order);
        $item->setProduct($product);
        $item->setPrice($product->getPrice());

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        // MAKE ASSERTIONS
        // Check that the item has been created
        $this->assertDatabaseHas('items', [
                'price' => $product->getPrice(),
                'order_id' => $order->getId(),
                'product_id' => $product->getId(),
            ]
        );

        // Check that we can retrieve items for an order e.g. $order->getItems()
        $this->assertCount(1, $order->getItems());
    }


    /** @test */
    public function multiple_items_can_be_added_to_an_order()
    {
        // SETUP
        $multiple = 3;

        // Need a product
        $name = 'Roland TD-07KV V-Drum Electronic Drum Kit BUNDLE';
        $description = 'Conveniently compact and ideal for drumming at home, the TD-07KV V-Drums kit delivers the superior expression and playability of high-end V-Drums in a budget-friendly package. ';

        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice(94400);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        // Need an order
        $order = $this->entityManager->getRepository(Order::class)->findOneBy([
            'deliveryName' => $this->deliveryName
        ]);

        // DO SOMETHING
        // Create multiple items using refs to the order and product
        for ($i = 1; $i <= $multiple; $i++) {

            $item = new Item();
            $item->setOrder($order);
            $item->setProduct($product);
            $item->setPrice($product->getPrice());

            $this->entityManager->persist($item);
        }

        $this->entityManager->flush();

        // MAKE ASSERTIONS
        // Check that the item has been created
        $this->assertDatabaseHasEntity(Item::class, [
                'price' => $product->getPrice(),
            ]
        );

        // Check that we can retrieve items for an order e.g. $order->getItems()
        $this->assertCount($multiple, $order->getItems());
    }
}









