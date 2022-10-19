<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Cazare
 *
 * @ORM\Table(name="cazare")
 * @ORM\Entity(repositoryClass="HotelsRepository")
 */
class Cazare
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cazare", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCazare;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nume", type="string", length=50, nullable=true)
     */
    private $nume;

    /**
     * @var string|null
     *
     * @ORM\Column(name="categorie", type="string", length=30, nullable=true)
     */
    private $categorie;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nr_camere", type="integer", nullable=true)
     */
    private $nrCamere;

    /**
     * @var float|null
     *
     * @ORM\Column(name="pret_noapte", type="float", precision=10, scale=0, nullable=true)
     */
    private $pretNoapte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresa", type="string", length=100, nullable=true)
     */
    private $adresa;

    /**
     * @return int
     */
    public function getIdCazare(): int
    {
        return $this->idCazare;
    }

    /**
     * @param int $idCazare
     */
    public function setIdCazare(int $idCazare): void
    {
        $this->idCazare = $idCazare;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HotelImage", mappedBy="hotel")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite", mappedBy="idCazare")
     */
    private $favorites;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int|null $rating
     */
    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
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
     * @return float|null
     */
    public function getPretNoapte(): ?float
    {
        return $this->pretNoapte;
    }

    /**
     * @param float|null $pretNoapte
     */
    public function setPretNoapte(?float $pretNoapte): void
    {
        $this->pretNoapte = $pretNoapte;
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

    public function addImage(HotelImage $image): self
    {
        if ($this->images->contains($image)) {
            throw new \InvalidArgumentException('Image already exists in hotels');
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
            throw new \InvalidArgumentException('Favorite already exists in hotels');
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
