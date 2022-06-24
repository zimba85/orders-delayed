<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *   normalizationContext={"groups"={"read"}},
 *   collectionOperations={
 *     "get"={
 *       "path"="/orders/v1/delayed",
 *     }
 *   },
 *   itemOperations={"get"}
 * )
 */
class OrderDelayed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    public int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order")
     * @Groups({"read"})
     */
    public Order $order;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    public DateTime $checkTime;

    /**
     * @ORM\Column(type="datetime")
     * @ApiFilter(DateFilter::class)
     * @Groups({"read"})
     */
    public DateTime $estimatedArrival;

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
