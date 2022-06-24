<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *   normalizationContext={"groups"={"read"}},
 *   collectionOperations={
 *     "get"={
 *       "path"="/orders/v1/",
 *     },
 *     "post"={
 *       "path"="/orders/v1/",
 *       "denormalization_context"={"groups"={"write"}}
 *     }
 *   },
 *   itemOperations={
 *     "get",
 *     "patch"={
 *       "path"="/orders/v1/{id}",
 *       "denormalization_context"={"groups"={"patch_write"}}
 *     }
 *   }
 * )
 * @ApiFilter(NumericFilter::class, properties={"id", "status.id"})
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    public int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrderStatus")
     * @Groups({"read", "patch_write"})
     */
    public OrderStatus $status;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @ApiFilter(DateFilter::class)
     * @Groups({"read", "write"})
     */
    public DateTime $estimatedArrival;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $deliveryAddress1;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $deliveryAddress2;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $deliveryCity;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $deliveryPostcode;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $deliveryCountry;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $billingAddress1;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $billingAddress2;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $billingCity;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $billingPostcode;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public string $billingCountry;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTime $updatedAt;

    /**
     * @ORM\PrePersist
     */
    public function createdTimestamp()
    {
        $this->createdAt = new DateTime('now');
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamp()
    {
        $this->updatedAt = new DateTime('now');
    }
}
