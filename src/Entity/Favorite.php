<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorite
 *
 * @ORM\Table(name="favorite", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="idArta", columns={"id_arta"}), @ORM\Index(name="idCazare", columns={"id_cazare"}), @ORM\Index(name="idMancareBautura", columns={"id_mancare_bautura"}), @ORM\Index(name="idMonumenteIstorice", columns={"id_monumente_istorice"})})
 * @ORM\Entity
 */
class Favorite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_favorite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFavorite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nume", type="string", length=50, nullable=true)
     */
    private $nume;

    /**
     * @var string|null
     *
     * @ORM\Column(name="categorie", type="string", length=20, nullable=true)
     */
    private $categorie;

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
     * @var Cazare
     *
     * @ORM\ManyToOne(targetEntity="Cazare")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cazare", referencedColumnName="id_cazare")
     * })
     */
    private ?Cazare $idCazare=null;

    /**
     * @var MancareBautura
     *
     * @ORM\ManyToOne(targetEntity="MancareBautura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mancare_bautura", referencedColumnName="id_mancare_bautura")
     * })
     */
    private ?MancareBautura $idMancareBautura=null;

    /**
     * @var MonumenteIstorice
     *
     * @ORM\ManyToOne(targetEntity="MonumenteIstorice", inversedBy="favorites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_monumente_istorice", referencedColumnName="id_monumente_istorice")
     * })
     */
    private ?MonumenteIstorice $idMonumenteIstorice=null;

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
    public function getIdFavorite(): int
    {
        return $this->idFavorite;
    }

    /**
     * @param int $idFavorite
     */
    public function setIdFavorite(int $idFavorite): void
    {
        $this->idFavorite = $idFavorite;
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
     * @return MancareBautura
     */
    public function getIdMancareBautura(): ?MancareBautura
    {
        return $this->idMancareBautura;
    }

    /**
     * @param MancareBautura $idMancareBautura
     */
    public function setIdMancareBautura(?MancareBautura $idMancareBautura): void
    {
        $this->idMancareBautura = $idMancareBautura;
    }

    /**
     * @return string|null
     */
    public function getNume(): ?string
    {
        return $this->nume;
    }

    /**
     * @param string|null $nume
     */
    public function setNume(?string $nume): void
    {
        $this->nume = $nume;
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
    public function getIdMonumenteIstorice(): ?MonumenteIstorice
    {
        return $this->idMonumenteIstorice;
    }

    /**
     * @param MonumenteIstorice $idMonumenteIstorice
     */
    public function setIdMonumenteIstorice(?MonumenteIstorice $idMonumenteIstorice): void
    {
        $this->idMonumenteIstorice = $idMonumenteIstorice;
    }

    /**
     * @return string|null
     */
    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    /**
     * @param string|null $categorie
     */
    public function setCategorie(?string $categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return Cazare
     */
    public function getIdCazare(): ?Cazare
    {
        return $this->idCazare;
    }

    /**
     * @param Cazare $idCazare
     */
    public function setIdCazare(?Cazare $idCazare): void
    {
        $this->idCazare = $idCazare;
    }


}
