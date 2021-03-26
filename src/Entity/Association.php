<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssociationRepository::class)
 */
class Association
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siege;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private $but;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombreMembre;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="associations")
     */
    private $UserA;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valid;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $budget;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $domaineAssociation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteWeb;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFondation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $president;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->siege;
    }

    public function setSiege(?string $siege): self
    {
        $this->siege = $siege;

        return $this;
    }

    public function getBut(): ?string
    {
        return $this->but;
    }

    public function setBut(?string $but): self
    {
        $this->but = $but;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNombreMembre(): ?int
    {
        return $this->nombreMembre;
    }

    public function setNombreMembre(?int $nombreMembre): self
    {
        $this->nombreMembre = $nombreMembre;

        return $this;
    }

    public function getUserA(): ?User
    {
        return $this->UserA;
    }

    public function setUserA(?User $UserA): self
    {
        $this->UserA = $UserA;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(?float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDomaineAssociation(): ?string
    {
        return $this->domaineAssociation;
    }

    public function setDomaineAssociation(?string $domaineAssociation): self
    {
        $this->domaineAssociation = $domaineAssociation;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getDateFondation(): ?\DateTimeInterface
    {
        return $this->dateFondation;
    }

    public function setDateFondation(?\DateTimeInterface $dateFondation): self
    {
        $this->dateFondation = $dateFondation;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPresident(): ?string
    {
        return $this->president;
    }

    public function setPresident(?string $president): self
    {
        $this->president = $president;

        return $this;
    }

}
