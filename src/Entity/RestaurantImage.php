<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RestaurantImage
 *
 * @ORM\Table(name="restaurant_image")
 * @ORM\Entity()
 */

class RestaurantImage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MancareBautura", inversedBy="images")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id_mancare_bautura")
     */
    private $restaurant;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPath(): string
    {
        return '/images/restaurant/'.$this->name;
    }
}
