<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserRepository")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
     * @ORM\Column(name="nume", type="string", length=20, nullable=true)
     */
    private $nume;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenume", type="string", length=20, nullable=true)
     */
    private $prenume;

    /**
     * @var string
     *
     * @ORM\Column(name="parola", type="string", length=20, nullable=false)
     */
    private $parola;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var boolean|null
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string|null
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

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
    public function getPrenume(): ?string
    {
        return $this->prenume;
    }

    /**
     * @param string|null $prenume
     */
    public function setPrenume(?string $prenume): void
    {
        $this->prenume = $prenume;
    }

    /**
     * @return string
     */
    public function getParola(): string
    {
        return $this->parola;
    }

    /**
     * @param string $parola
     */
    public function setParola(string $parola): void
    {
        $this->parola = $parola;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }


    public function getRoles(): array
    {
        return [
            'ROLE_USER'
        ];
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return 'email';
    }

    public function getPassword(): ?string
    {
        if(!$this->getEnabled())
        {
            return 'abhjvaekjbflasdhjnwalfaj;el.vrbkns.dklfmdz';
        }

        return $this->parola;
    }

    /**
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool|null $enabled
     */
    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }
}
