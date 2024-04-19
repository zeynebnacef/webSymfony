<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")

 * @UniqueEntity(fields={"numTel"}, message="Ce numéro de téléphone est déjà utilisé.")
 * * @UniqueEntity(fields={"email"}, message="Cet email est déjà utilisé.")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idu;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le prénom est obligatoire.")
     */
    private $prenom;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le mot de passe est obligatoire.")
     * @Assert\Length(min=6, minMessage="Le mot de passe doit contenir au moins {{ limit }} caractères.")
     */
    private $password;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="La date de naissance est obligatoire.")
     * @Assert\Type("\DateTimeInterface")
     */
    private $datenaissance;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="L'email est obligatoire.")
     * @Assert\Email(message="L'email '{{ value }}' n'est pas valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le numéro de téléphone est obligatoire.")
     * @Assert\Length(
     *      min=8,
     *      max=8,
     *      exactMessage="Le numéro de téléphone doit contenir exactement {{ limit }} chiffres."
     * )
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="La localisation est obligatoire.")
     */
    private $localisation;

    /**
     * @ORM\Column(type="string", length=32, options={"default"="Simple user"})
     */
    private $role = 'Simple user';


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage = "Veuillez télécharger une image valide (jpg, png, gif)"
     * )
     */
    private $imageFile;

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;
        return $this;
    }

    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?UploadedFile $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->numTel;
    }

    public function setNumTel(int $numTel): self
    {
        $this->numTel = $numTel;
        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return [$this->getRole()];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }
}
