<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CvRepository")
 */
class Cv
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $post;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $format;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="cvs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Version", mappedBy="cv")
     */
    private $versions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Connaissances", mappedBy="cv")
     */
    private $connaissances;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Langues", mappedBy="cv")
     */
    private $langues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Loisirs", mappedBy="cv")
     */
    private $loisirs;

    /**
     * @ORM\Column(type="date", nullable=true) 
     *  @var \DateTime
     */
  
    private $date;

    public function __construct()
    {        $user = $this->getUser();

        $this->versions = new ArrayCollection();
        $this->connaissances = new ArrayCollection();
        $this->langues = new ArrayCollection();
        $this->loisirs = new ArrayCollection();
        $this->date = new \DateTime();
        $this->titre='NB';
        $this->owner=$user.id;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Version[]
     */
    public function getVersions(): Collection
    {
        return $this->versions;
    }

    public function addVersion(Version $version): self
    {
        if (!$this->versions->contains($version)) {
            $this->versions[] = $version;
            $version->setCv($this);
        }

        return $this;
    }

    public function removeVersion(Version $version): self
    {
        if ($this->versions->contains($version)) {
            $this->versions->removeElement($version);
            // set the owning side to null (unless already changed)
            if ($version->getCv() === $this) {
                $version->setCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Connaissances[]
     */
    public function getConnaissances(): Collection
    {
        return $this->connaissances;
    }

    public function addConnaissance(Connaissances $connaissance): self
    {
        if (!$this->connaissances->contains($connaissance)) {
            $this->connaissances[] = $connaissance;
            $connaissance->setCv($this);
        }

        return $this;
    }

    public function removeConnaissance(Connaissances $connaissance): self
    {
        if ($this->connaissances->contains($connaissance)) {
            $this->connaissances->removeElement($connaissance);
            // set the owning side to null (unless already changed)
            if ($connaissance->getCv() === $this) {
                $connaissance->setCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Langues[]
     */
    public function getLangues(): Collection
    {
        return $this->langues;
    }

    public function addLangue(Langues $langue): self
    {
        if (!$this->langues->contains($langue)) {
            $this->langues[] = $langue;
            $langue->setCv($this);
        }

        return $this;
    }

    public function removeLangue(Langues $langue): self
    {
        if ($this->langues->contains($langue)) {
            $this->langues->removeElement($langue);
            // set the owning side to null (unless already changed)
            if ($langue->getCv() === $this) {
                $langue->setCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Loisirs[]
     */
    public function getLoisirs(): Collection
    {
        return $this->loisirs;
    }

    public function addLoisir(Loisirs $loisir): self
    {
        if (!$this->loisirs->contains($loisir)) {
            $this->loisirs[] = $loisir;
            $loisir->setCv($this);
        }

        return $this;
    }

    public function removeLoisir(Loisirs $loisir): self
    {
        if ($this->loisirs->contains($loisir)) {
            $this->loisirs->removeElement($loisir);
            // set the owning side to null (unless already changed)
            if ($loisir->getCv() === $this) {
                $loisir->setCv(null);
            }
        }

        return $this;
    }

       public function getDate(): \DateTime
       {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

}
