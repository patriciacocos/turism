<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use App\Validator as Assert;

/**
 * RezervareCazare
 *
 * @ORM\Table(name="rezervare_cazare", indexes={@ORM\Index(name="id_cazare", columns={"id_cazare"}), @ORM\Index(name="user_id", columns={"id_user"})})
 * @ORM\Entity
 * @Assert\HotelReservationDateRange
 */
class RezervareCazare
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nume_user", type="string", length=50, nullable=true)
     */
    private $numeUser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nr_camere", type="integer", nullable=true)
     */
    private $nrCamere;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_sosire", type="date", nullable=true)
     */
    private ?\DateTime $dataSosire = null;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_plecare", type="date",nullable=true)
     */
    private ?\DateTime $dataPlecare = null;

    /**
     * @var Cazare
     *
     * @ORM\ManyToOne(targetEntity="Cazare")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cazare", referencedColumnName="id_cazare")
     * })
     */
    private $idCazare;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;



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
     * @return string|null
     */
    public function getNumeUser(): ?string
    {
        return $this->numeUser;
    }

    /**
     * @param string|null $numeUser
     */
    public function setNumeUser(?string $numeUser): void
    {
        $this->numeUser = $numeUser;
    }

    /**
     * @return int|null
     */
    public function getNrCamere(): ?int
    {
        return $this->nrCamere;
    }

    /**
     * @param int|null $nrCamere
     */
    public function setNrCamere(?int $nrCamere): void
    {
        $this->nrCamere = $nrCamere;
    }

    /**
     * @return User
     */
    public function getIdUser(): User
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser(User $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return Cazare
     */
    public function getIdCazare(): Cazare
    {
        return $this->idCazare;
    }

    /**
     * @param Cazare $idCazare
     */
    public function setIdCazare(Cazare $idCazare): void
    {
        $this->idCazare = $idCazare;
    }

    /**
     * @return \DateTime|null
     */
    public function getDataSosire(): ?\DateTime
    {
        return $this->dataSosire;
    }

    /**
     * @param \DateTime|null $dataSosire
     */
    public function setDataSosire(?\DateTime $dataSosire): self
    {
        $this->dataSosire = $dataSosire;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDataPlecare(): ?\DateTime
    {
        return $this->dataPlecare;
    }

    /**
     * @param \DateTime|null $dataPlecare
     */
    public function setDataPlecare(?\DateTime $dataPlecare): self
    {
        $this->dataPlecare = $dataPlecare;
        return $this;
    }


}
