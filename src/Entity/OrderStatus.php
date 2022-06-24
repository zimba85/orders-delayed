<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table
 * @ApiResource(
 *   normalizationContext={"groups"={"read"}},
 *   collectionOperations={
 *     "get"={
 *       "path"="/order-statuses/",
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "path"="/order-statuses/{id}",
 *     }
 *   }
 * )
 */
class OrderStatus
{
    public const CREATED = 1;
    public const DISPATCHED = 2;
    public const DELIVERED = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    public int $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"read"})
     */
    public string $name;

    /**
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id = 0, string $name = "")
    {
        $this->id = $id;
        $this->name = $name;
    }
}
