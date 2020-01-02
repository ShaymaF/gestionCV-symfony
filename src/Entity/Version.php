<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VersionRepository")
 */
class Version
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\cv", inversedBy="versions")
     */
    private $cv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="versions")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\About", inversedBy="versions")
     */
    private $about;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competence", inversedBy="versions")
     */
    private $competence;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Connaissances", inversedBy="versions")
     */
    private $connaissance;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", inversedBy="versions")
     */
    private $formation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Langues", inversedBy="versions")
     */
    private $langue;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Loisirs", inversedBy="versions")
     */
    private $loisir;

    public function __construct()
    {
        $this->about = new ArrayCollection();
        $this->competence = new ArrayCollection();
        $this->connaissance = new ArrayCollection();
        $this->formation = new ArrayCollection();
        $this->langue = new ArrayCollection();
        $this->loisir = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
         $this->id = $id;
         return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getCv(): ?cv
    {
        return $this->cv;
    }

    public function setCv(?cv $cv): self
    {
        $this->cv = $cv;

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    
}
