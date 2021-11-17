<?php

use App\Entity\Item;
use App\Entity\Order;
use Doctrine\ORM\EntityManager;

require_once dirname(__DIR__, 2) . '/bootstrap.php';

/** @var EntityManager $em */
$em = $entityManager;

// Obtain product
$product = $em->getRepository(\App\Entity\Product::class)->find($_POST['product']['id']);

// Create and persist an order
$deliveryName = htmlentities($_POST['address']['name'], ENT_QUOTES, 'UTF-8');
$deliveryAddress = $_POST['address']['street-address'] . ', ' . $_POST['address']['city'] . ', ' . $_POST['address']['country'] . ', ' . $_POST['address']['zip'];
$deliveryAddress = htmlentities($deliveryAddress, ENT_QUOTES, 'UTF-8');

$order = new Order();
$order->setDeliveryName($deliveryName);
$order->setDeliveryAddress($deliveryAddress);
$em->persist($order);
$em->flush();

// Create and persist an item
$item = new Item();
$item->setPrice($product->getPrice());
$item->setProduct($product);
$item->setOrder($order);
$em->persist($item);
$em->flush();

dd($order->getId(), $item->getId());

$title = 'Order Status';

include dirname(__DIR__, 1) . '/includes/site-header.php';

