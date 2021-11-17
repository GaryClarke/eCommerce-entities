<?php

namespace App\Tests;

use App\Session\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /** @test */
    public function can_check_if_a_session_is_started()
    {
        // SETUP
        // Create a session object
        $session = new Session();

        // Assert session is not started
        $this->assertFalse($session->isStarted());
    }

    /** @test */
    public function a_session_can_be_started()
    {
        // SETUP
        $session = new Session();

        // DO SOMETHING
        $sessionStatus = $session->start();

        // MAKE ASSERTIONS
        $this->assertTrue($session->isStarted());
        $this->assertTrue($sessionStatus);
    }

    /** @test */
    public function items_can_be_added_to_the_session()
    {
        // SETUP
        $productId1 = 1;
        $productId2 = 2;

        $session = new Session();
        $session->start();

        // DO SOMETHING
        $session->set('cart.items', [
            $productId1 => ['quantity' => 1, 'price' => 1099],
            $productId2 => ['quantity' => 2, 'price' => 599],
        ]);

        // MAKE ASSERTIONS
        $this->assertArrayHasKeys($_SESSION['cart.items'], [$productId1, $productId2]);
    }

    /** @test */
    public function can_check_that_an_item_exists_in_a_session()
    {
        // SETUP
        $session = new Session();
        $session->start();

        // DO SOMETHING
        $session->set('auth.id', 1);

        // MAKE ASSERTIONS
        $this->assertTrue($session->has('auth.id'));
        $this->assertFalse($session->has('false.key'));
    }


    /** @test */
    public function can_retrieve_an_item_from_the_session()
    {
        // SETUP
        $session = new Session();
        $session->start();
        $session->set('auth.id', 678);

        // DO SOMETHING
        $authId = $session->get('auth.id');
        $falseItem = $session->get('false.item');
        $retrievedDefault = $session->get('false.item', 'retrieved default');

        // MAKE ASSERTIONS
        $this->assertEquals(678, $authId);
        $this->assertNull($falseItem);
        $this->assertEquals('retrieved default', $retrievedDefault);
    }

    /** @test */
    public function items_can_be_removed_by_key()
    {
        // SETUP
        $session = new Session();
        $session->start();
        $session->set('auth.id', 678);

        // DO SOMETHING
        $session->remove('auth.id');

        // MAKE ASSERTIONS
        $this->assertNull($session->get('auth.id'));
    }


    /** @test */
    public function the_session_can_be_cleared()
    {
        // SETUP
        $session = new Session();
        $session->start();
        $session->set('key1', 'foo');
        $session->set('key2', 'bar');

        // DO SOMETHING
        $session->clear();

        // MAKE ASSERTIONS
        $this->assertEmpty($_SESSION);
    }


    public function assertArrayHasKeys(array $array, array $keys)
    {
        $diff = array_diff($keys, array_keys($array));

        $this->assertTrue(!$diff,
            'The array does not contain the following key(s): ' . implode(', ', $diff));
    }
}











