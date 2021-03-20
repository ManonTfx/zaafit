<?php

namespace App\Entity;

use App\Repository\PoidsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PoidsRepository::class)
 */
class Poids
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=1)
     */
    public $user_poids;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="poids_user")
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    public $date_jour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPoids(): ?string
    {
        return $this->user_poids;
    }

    public function setUserPoids(string $user_poids): self
    {
        $this->user_poids = $user_poids;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDateJour(): ?\DateTimeInterface
    {
        return $this->date_jour;
    }

    public function setDateJour(\DateTimeInterface $date_jour): self
    {
        $this->date_jour = $date_jour;

        return $this;
    }
}
