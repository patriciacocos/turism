<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Arta
 *
 * @ORM\Table(name="arta")
 * @ORM\Entity(repositoryClass="ArtRepository")
 */
class Arta
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_arta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $idArta;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="ora_deschidere", type="time", nullable=true)
     */
    private $oraDeschidere;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ora_inchidere", type="time", nullable=true)
     */
    private $oraInchidere;

    /**
     * @var float|null
     *
     * @ORM\Column(name="pret_bilet", type="float", precision=10, scale=0, nullable=true)
     */
    private $pretBilet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresa", type="string", length=100, nullable=true)
     */
    private $adresa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArtImage", mappedBy="art")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite", mappedBy="idArta")
     */
    private $favorites;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdArta(): int
    {
        return $this->idArta;
    }

    /**
     * @param int $idArta
     */
    public function setIdArta(int $idArta): void
    {
        $this->idArta = $idArta;
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
     * @return \DateTime|null
     */
    public function getOraDeschidere(): ?\DateTime
    {
        return $this->oraDeschidere;
    }

    /**
     * @param \DateTime|null $oraDeschidere
     */
    public function setOraDeschidere(?\DateTime $oraDeschidere): void
    {
        $this->oraDeschidere = $oraDeschidere;
    }

    /**
     * @return \DateTime|null
     */
    public function getOraInchidere(): ?\DateTime
    {
        return $this->oraInchidere;
    }

    /**
     * @param \DateTime|null $oraInchidere
     */
    public function setOraInchidere(?\DateTime $oraInchidere): void
    {
        $this->oraInchidere = $oraInchidere;
    }

    /**
     * @return float|null
     */
    public function getPretBilet(): ?float
    {
        return $this->pretBilet;
    }

    /**
     * @param float|null $pretBilet
     */
    public function setPretBilet(?float $pretBilet): void
    {
        $this->pretBilet = $pretBilet;
    }

    /**
     * @return string|null
     */
    public function getAdresa(): ?string
    {
        return $this->adresa;
    }

    /**
     * @param string|null $adresa
     */
    public function setAdresa(?string $adresa): void
    {
        $this->adresa = $adresa;
    }

    /**
     * @return ArrayCollection
     */
    public function getImages(): ArrayCollection | PersistentCollection
    {
        return $this->images;
    }

    /**
     * @param ArrayCollection $images
     */
    public function setImages(ArrayCollection $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function addImage(ArtImage $image): self
    {
        if ($this->images->contains($image)) {
            throw new \InvalidArgumentException('Image already exists in art');
        }

        $this->images->add($image);

        return $this;
    }

    public function removeImage(ArtImage $image): void
    {
        $this->images->removeElement($image);
    }

    /**
     * @return ArrayCollection
     */
    public function getFavorites(): ArrayCollection | PersistentCollection
    {
        return $this->favorites;
    }

    /**
     * @param ArrayCollection $favorites
     */
    public function setFavorites(ArrayCollection $favorites): self
    {
        $this->favorites = $favorites;

        return $this;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if ($this->favorites->contains($favorite)) {
            throw new \InvalidArgumentException('Favorite already exists in arta');
        }

        $this->favorites->add($favorite);

        return $this;
    }

    public function removeFavorite(Favorite $favorite): void
    {
        $this->images->removeElement($favorite);
    }

    public function hasFavoriteForUser(UserInterface $user)
    {
        return $this->getFavorites()->filter(function (Favorite $a) use ($user){
                if($a->getIdUser()->getId()==$user->getId())
                {
                    return $a;
                }
            })->count()>0;
    }


}
