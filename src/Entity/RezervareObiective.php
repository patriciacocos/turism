<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RezervareObiective
 *
 * @ORM\Table(name="rezervare_obiective", indexes={@ORM\Index(name="id_arta", columns={"id_arta"}), @ORM\Index(name="id_monument", columns={"id_monument"}), @ORM\Index(name="user", columns={"id_user"})})
 * @ORM\Entity
 */
class RezervareObiective
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="ora_rezervarii", type="time", nullable=true)
     */
    private $oraRezervarii;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nr_locuri", type="integer", nullable=true)
     */
    private $nrLocuri;

    /**
     * @var Arta
     *
     * @ORM\ManyToOne(targetEntity="Arta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arta", referencedColumnName="id_arta")
     * })
     */
    private ?Arta $idArta=null;

    /**
     * @var MonumenteIstorice
     *
     * @ORM\ManyToOne(targetEntity="MonumenteIstorice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_monument", referencedColumnName="id_monumente_istorice")
     * })
     */
    private ?MonumenteIstorice $idMonument=null;

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
     * @return \DateTime|null
     */
    public function getOraRezervarii(): ?\DateTime
    {
        return $this->oraRezervarii;
    }

    /**
     * @param \DateTime|null $oraRezervarii
     */
    public function setOraRezervarii(?\DateTime $oraRezervarii): void
    {
        $this->oraRezervarii = $oraRezervarii;
    }

    /**
     * @return int|null
     */
    public function getNrLocuri(): ?int
    {
        return $this->nrLocuri;
    }

    /**
     * @param int|null $nrLocuri
     */
    public function setNrLocuri(?int $nrLocuri): void
    {
        $this->nrLocuri = $nrLocuri;
    }

    /**
     * @return Arta
     */
    public function getIdArta(): ?Arta
    {
        return $this->idArta;
    }

    /**
     * @param Arta $idArta
     */
    public function setIdArta(?Arta $idArta): void
    {
        $this->idArta = $idArta;
    }

    /**
     * @return MonumenteIstorice
     */
    public function getIdMonument(): ?MonumenteIstorice
    {
        return $this->idMonument;
    }

    /**
     * @param MonumenteIstorice $idMonument
     */
    public function setIdMonument(?MonumenteIstorice $idMonument): void
    {
        $this->idMonument = $idMonument;
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


}
