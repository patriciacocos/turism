<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * MancareBautura
 *
 * @ORM\Table(name="mancare_bautura")
 * @ORM\Entity(repositoryClass="RestaurantCafeRepository")
 */
class MancareBautura
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mancare_bautura", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMancareBautura;

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
     * @var string|null
     *
     * @ORM\Column(name="stil", type="string", length=20, nullable=true)
     */
    private $stil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresa", type="string", length=100, nullable=true)
     */
    private $adresa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RestaurantImage", mappedBy="restaurant")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite", mappedBy="idMancareBautura")
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
    public function getIdMancareBautura(): int
    {
        return $this->idMancareBautura;
    }

    /**
     * @param int $idMancareBautura
     */
    public function setIdMancareBautura(int $idMancareBautura): void
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
     * @return string|null
     */
    public function getStil(): ?string
    {
        return $this->stil;
    }

    /**
     * @param string|null $stil
     */
    public function setStil(?string $stil): void
    {
        $this->stil = $stil;
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
            throw new \InvalidArgumentException('Image already exists in restaurant');
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
            throw new \InvalidArgumentException('Favorite already exists in restaurant');
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
