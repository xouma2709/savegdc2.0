<?php

namespace App\Entity;

use App\Repository\FonctionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FonctionsRepository::class)
 */
class Fonctions
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
    private $FonctionLibelle;

    /**
     * @ORM\OneToMany(targetEntity=Agents::class, mappedBy="Fonction")
     */
    private $agents;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFonctionLibelle(): ?string
    {
        return $this->FonctionLibelle;
    }

    public function setFonctionLibelle(string $FonctionLibelle): self
    {
        $this->FonctionLibelle = $FonctionLibelle;

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
            $agent->setFonction($this);
        }

        return $this;
    }

    public function removeAgent(Agents $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getFonction() === $this) {
                $agent->setFonction(null);
            }
        }

        return $this;
    }
}
