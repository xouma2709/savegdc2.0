<?php

namespace App\Entity;

use App\Repository\SecteursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecteursRepository::class)
 */
class Secteurs
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
    private $SecteurLibelle;

    /**
     * @ORM\OneToMany(targetEntity=Agents::class, mappedBy="Secteur")
     */
    private $agents;

    /**
     * @ORM\ManyToOne(targetEntity=Etablissements::class, inversedBy="secteurs")
     */
    private $etablissements;



    public function __construct()
    {
        $this->agents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecteurLibelle(): ?string
    {
        return $this->SecteurLibelle;
    }

    public function setSecteurLibelle(string $SecteurLibelle): self
    {
        $this->SecteurLibelle = $SecteurLibelle;

        return $this;
    }

    /**
     * @return Collection|Agents[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agents $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setSecteur($this);
        }

        return $this;
    }

    public function removeAgent(Agents $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getSecteur() === $this) {
                $agent->setSecteur(null);
            }
        }
        return $this;
    }

    public function getEtablissements(): ?Etablissements
    {
        return $this->etablissements;
    }

    public function setEtablissements(?Etablissements $etablissements): self
    {
        $this->etablissements = $etablissements;

        return $this;
    }
}
