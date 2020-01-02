<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)  @Assert\NotBlank
     */
    private $competenceField;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="competences")
     */
    private $user;

       /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Version",inversedBy="competences")
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

    public function getCompetenceField(): ?string
    {
        return $this->competenceField;
    }

    public function setCompetenceField(?string $competenceField): self
    {
        $this->competenceField = $competenceField;

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
