<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonumentIstoricImage
 *
 * @ORM\Table(name="monument_istoric_image")
 * @ORM\Entity()
 */

class MonumentIstoricImage
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
     * Many images have one monument istoric. This is the owning side.
     * @ORM\ManyToOne(targetEntity="App\Entity\MonumenteIstorice", inversedBy="images")
     * @ORM\JoinColumn(name="monumente_istorice_id", referencedColumnName="id_monumente_istorice")
     */
    private $monumentIstoric;

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
        return '/images/monument/'.$this->name;
    }
}
