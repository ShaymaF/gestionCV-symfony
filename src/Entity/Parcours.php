<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ParcoursRepository")
 */
class Parcours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true) @Assert\NotBlank
     */
    private $post;

    /**
     * @ORM\Column(type="string", length=255, nullable=true) @Assert\NotBlank
     */
    private $emplacement;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true) @Assert\NotBlank
     */
    private $mission;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true) @Assert\NotBlank
     */
    private $technologies;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true) @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true) @Assert\NotBlank
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true) @Assert\NotBlank
     */
    private $datefin;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $projet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="parcours")
     */
    private $user;

       /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Version",inversedBy="parcours")
     */
    private $version;

    public function getVersion(): ?Version
    {
        return $this->version;
    }

    public function setVersion(?Version $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(?string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(?string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(?string $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getTechnologies(): ?string
    {
        return $this->technologies;
    }

    public function setTechnologies(?string $technologies): self
    {
        $this->technologies = $technologies;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getProjet(): ?string
    {
        return $this->projet;
    }

    public function setProjet(?string $projet): self
    {
        $this->projet = $projet;

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

    /**
     * @return Collection|self[]
     */
    public function getParcour(): Collection
    {
        return $this->parcour;
    }

    public function addParcour(self $parcour): self
    {
        if (!$this->parcour->contains($parcour)) {
            $this->parcour[] = $parcour;
        }

        return $this;
    }

    public function removeParcour(self $parcour): self
    {
        if ($this->parcour->contains($parcour)) {
            $this->parcour->removeElement($parcour);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParcours(): Collection
    {
        return $this->parcours;
    }
}
