<?php

namespace App\Entity;

use App\Repository\SoftsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoftsRepository::class)
 */
class Softs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $SoftLibelle;

    /**
     * @ORM\Column(type="boolean", nullable =true)
     */
    private $SynchroAD;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Precisions;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @ORM\ManyToMany(targetEntity=Comptes::class, mappedBy="softs")
     */
    private $comptes;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoftLibelle(): ?string
    {
        return $this->SoftLibelle;
    }

    public function setSoftLibelle(string $SoftLibelle): self
    {
        $this->SoftLibelle = $SoftLibelle;

        return $this;
    }

    public function getSynchroAD(): ?bool
    {
        return $this->SynchroAD;
    }

    public function setSynchroAD(bool $SynchroAD): self
    {
        $this->SynchroAD = $SynchroAD;

        return $this;
    }

    public function getPrecisions(): ?string
    {
        return $this->Precisions;
    }

    public function setPrecisions(?string $Precisions): self
    {
        $this->Precisions = $Precisions;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection|Comptes[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Comptes $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->addSoft($this);
        }

        return $this;
    }

    public function removeCompte(Comptes $compte): self
    {
        if ($this->comptes->removeElement($compte)) {
            $compte->removeSoft($this);
        }

        return $this;
    }
}
