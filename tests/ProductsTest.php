<?php

namespace App\Tests;

use App\Entity\Product;

class ProductsTest extends DatabaseDependantTestCase
{
    /** @test */
    public function a_product_can_be_created()
    {
        // SETUP
        $name = 'Roland TD-07KV V-Drum Electronic Drum Kit BUNDLE';
        $description = 'Conveniently compact and ideal for drumming at home, the TD-07KV V-Drums kit delivers the superior expression and playability of high-end V-Drums in a budget-friendly package. ';

        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice(94400);

        // DO SOMETHING
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        // MAKE ASSERTIONS
        $this->assertDatabaseHasEntity(Product::class,
            ['name' => $name, 'description' => $description]
        );

        $this->assertDatabaseNotHas(Product::class,
            ['name' => $name, 'description' => 'foobar']
        );
    }

    /** @test */
    public function can_test_a_product_is_in_the_database()
    {
        // SETUP
        $name = 'Roland TD-07KV V-Drum Electronic Drum Kit BUNDLE';
        $description = 'Conveniently compact and ideal for drumming at home, the TD-07KV V-Drums kit delivers the superior expression and playability of high-end V-Drums in a budget-friendly package. ';

        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice(94400);

        // DO SOMETHING
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        // MAKE ASSERTIONS
        $this->assertDatabaseHas('products', [
            'name' => $name,
            'description' => $description
        ]);
    }
}