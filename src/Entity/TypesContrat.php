<?php

namespace App\Entity;

use App\Repository\TypesContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypesContratRepository::class)
 */
class TypesContrat
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
    private $TypeContratLibelle;

    /**
     * @ORM\OneToMany(targetEntity=Contrats::class, mappedBy="TypeContrat")
     */
    private $contrats;

    public function __construct()
    {
        $this->typeContrats = new ArrayCollection();
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeContratLibelle(): ?string
    {
        return $this->TypeContratLibelle;
    }

    public function setTypeContratLibelle(string $TypeContratLibelle): self
    {
        $this->TypeContratLibelle = $TypeContratLibelle;

        return $this;
    }

    /**
     * @return Collection|Contrats[]
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrats $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->setTypeContrat($this);
        }

        return $this;
    }

    public function removeContrat(Contrats $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getTypeContrat() === $this) {
                $contrat->setTypeContrat(null);
            }
        }

        return $this;
    }

}
