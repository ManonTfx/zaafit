<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_jour_sport;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_de_sport;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_minutes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sports")
     */
    private $user;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=1)
     */
    private $poids_user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $calories_depensees;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateJourSport(): ?\DateTimeInterface
    {
        return $this->date_jour_sport;
    }

    public function setDateJourSport(\DateTimeInterface $date_jour_sport): self
    {
        $this->date_jour_sport = $date_jour_sport;

        return $this;
    }

    public function getTypeDeSport(): ?string
    {
        return $this->type_de_sport;
    }

    public function setTypeDeSport(string $type_de_sport): self
    {
        $this->type_de_sport = $type_de_sport;

        return $this;
    }

    public function getDureeMinutes(): ?int
    {
        return $this->duree_minutes;
    }

    public function setDureeMinutes(int $duree_minutes): self
    {
        $this->duree_minutes = $duree_minutes;

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

    public function getPoidsUser(): ?string
    {
        return $this->poids_user;
    }

    public function setPoidsUser(string $poids_user): self
    {
        $this->poids_user = $poids_user;

        return $this;
    }

    public function getCaloriesDepensees(): ?int
    {
        return $this->calories_depensees;
    }

    public function setCaloriesDepensees(?int $calories_depensees): self
    {
        $this->calories_depensees = $calories_depensees;

        return $this;
    }
}
