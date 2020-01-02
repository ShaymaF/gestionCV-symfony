<?php
// src/Entity/User.php

namespace App\Entity;
use DoL\LdapBundle\Model\LdapUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements LdapUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $dn;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cv", mappedBy="owner", orphanRemoval=true)
     */
    private $cvs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $post;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateEmbauche;

       /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasCV=false;

    public function __construct()
    {
        parent::__construct();

        // your own logic
    }

    /**
     * Set Ldap Distinguished Name.
     *
     * @param string $dn Distinguished Name
     */
    public function setDn($dn)
    {
        $this->dn = $dn;
    }
    /**
     * Get Ldap Distinguished Name.
     *
     * @return string Distinguished Name
     */
    public function getDn()
    {
        return $this->dn;
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

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(?\DateTimeInterface $dateEmbauche): self
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }
    public function getHasCv(): ?bool
    {
        return $this->hasCV;
    }
    
    public function setHasCv(?bool $hasCV): self
    {
        $this->hasCV = $hasCV;
    
        return $this;
    }

   
}