<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FoodRepository::class)
 */
class Food
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
    public $date_jour_repas;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $petit_dejeuner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $dejeuner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $encas;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $diner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $note_journee;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="food")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateJourRepas(): ?\DateTimeInterface
    {
        return $this->date_jour_repas;
    }

    public function setDateJourRepas(\DateTimeInterface $date_jour_repas): self
    {
        $this->date_jour_repas = $date_jour_repas;

        return $this;
    }

    public function getPetitDejeuner(): ?string
    {
        return $this->petit_dejeuner;
    }

    public function setPetitDejeuner(?string $petit_dejeuner): self
    {
        $this->petit_dejeuner = $petit_dejeuner;

        return $this;
    }

    public function getDejeuner(): ?string
    {
        return $this->dejeuner;
    }

    public function setDejeuner(?string $dejeuner): self
    {
        $this->dejeuner = $dejeuner;

        return $this;
    }

    public function getEncas(): ?string
    {
        return $this->encas;
    }

    public function setEncas(?string $encas): self
    {
        $this->encas = $encas;

        return $this;
    }

    public function getDiner(): ?string
    {
        return $this->diner;
    }

    public function setDiner(?string $diner): self
    {
        $this->diner = $diner;

        return $this;
    }

    public function getNoteJournee(): ?string
    {
        return $this->note_journee;
    }

    public function setNoteJournee(?string $note_journee): self
    {
        $this->note_journee = $note_journee;

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
}
