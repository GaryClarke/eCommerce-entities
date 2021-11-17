<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="delivery_name")
     */
    private $deliveryName;

    /**
     * @ORM\Column(type="text", name="delivery_address")
     */
    private $deliveryAddress;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="order")
     */
    private $items;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="cancelled_at", nullable=true)
     * @var \DateTimeInterface
     */
    private ?\DateTimeImmutable $cancelledAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->items = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDeliveryName()
    {
        return $this->deliveryName;
    }

    /**
     * @param mixed $deliveryName
     */
    public function setDeliveryName($deliveryName): void
    {
        $this->deliveryName = $deliveryName;
    }

    /**
     * @return mixed
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * @param mixed $deliveryAddress
     */
    public function setDeliveryAddress($deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeImmutable|\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCancelledAt(): \DateTimeImmutable|\DateTimeInterface|null
    {
        return $this->cancelledAt;
    }

    /**
     * @param \DateTimeInterface $cancelledAt
     */
    public function setCancelledAt(\DateTimeImmutable|\DateTimeInterface|null $cancelledAt): void
    {
        $this->cancelledAt = $cancelledAt;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }
}









