<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $prenom;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @Vich\UploadableField(mapping="user_profil_picture", fileNameProperty="photo")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity=Poids::class, mappedBy="user")
     */
    private $poids;

    /**
     * @ORM\OneToMany(targetEntity=Poids::class, mappedBy="user")
     * @ORM\OrderBy({"date_jour" = "ASC"})
     */
    private $poids_user;

    /**
     * @ORM\Column(type="integer")
     */
    private $taille_user;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=1)
     */
    private $objectif_poids;


    /**
     * @ORM\Column(type="string", length=1)
     */
    private $sexe;

    /**
     * @ORM\OneToMany(targetEntity=Food::class, mappedBy="user")
     * @ORM\OrderBy({"date_jour_repas" = "DESC"})
     */
    private $food;

    /**
     * @ORM\OneToMany(targetEntity=Sport::class, mappedBy="user")
     * @ORM\OrderBy({"date_jour_sport" = "DESC"})
     */
    private $sports;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->updateAt = new \DateTime();
        $this->poids = new ArrayCollection();
        $this->poids_user = new ArrayCollection();
        $this->food = new ArrayCollection();
        $this->sports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return  File
     * 
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File  $imageFile
     *
     * @return  self
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function serialize()
    {

        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {

        list(
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * @return Collection|Poids[]
     */
    public function getPoids(): Collection
    {
        return $this->poids;
    }

    public function addPoid(Poids $poid): self
    {
        if (!$this->poids->contains($poid)) {
            $this->poids[] = $poid;
            $poid->setUser($this);
        }

        return $this;
    }

    public function removePoid(Poids $poid): self
    {
        if ($this->poids->removeElement($poid)) {
            // set the owning side to null (unless already changed)
            if ($poid->getUser() === $this) {
                $poid->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Poids[]
     */
    public function getPoidsUser(): Collection
    {
        return $this->poids_user;
    }

    public function addPoidsUser(Poids $poidsUser): self
    {
        if (!$this->poids_user->contains($poidsUser)) {
            $this->poids_user[] = $poidsUser;
            $poidsUser->setUser($this);
        }

        return $this;
    }

    public function removePoidsUser(Poids $poidsUser): self
    {
        if ($this->poids_user->removeElement($poidsUser)) {
            // set the owning side to null (unless already changed)
            if ($poidsUser->getUser() === $this) {
                $poidsUser->setUser(null);
            }
        }

        return $this;
    }

    public function getTailleUser(): ?int
    {
        return $this->taille_user;
    }

    public function setTailleUser(int $taille_user): self
    {
        $this->taille_user = $taille_user;

        return $this;
    }

    public function getObjectifPoids(): ?string
    {
        return $this->objectif_poids;
    }

    public function setObjectifPoids(string $objectif_poids): self
    {
        $this->objectif_poids = $objectif_poids;

        return $this;
    }


    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection|Food[]
     */
    public function getFood(): Collection
    {
        return $this->food;
    }

    public function addFood(Food $food): self
    {
        if (!$this->food->contains($food)) {
            $this->food[] = $food;
            $food->setUser($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->food->removeElement($food)) {
            // set the owning side to null (unless already changed)
            if ($food->getUser() === $this) {
                $food->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sport[]
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
            $sport->setUser($this);
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sports->removeElement($sport)) {
            // set the owning side to null (unless already changed)
            if ($sport->getUser() === $this) {
                $sport->setUser(null);
            }
        }

        return $this;
    }
}
