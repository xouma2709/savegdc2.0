<?php

namespace App\Entity;

use App\Repository\EtablissementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtablissementsRepository::class)
 */
class Etablissements
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etabLibelle;

    /**
     * @ORM\OneToMany(targetEntity=Secteurs::class, mappedBy="etablissements")
     */
    private $secteurs;

    public function __construct()
    {
        $this->secteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtabLibelle(): ?string
    {
        return $this->etabLibelle;
    }

    public function setEtabLibelle(string $etabLibelle): self
    {
        $this->etabLibelle = $etabLibelle;

        return $this;
    }

    /**
     * @return Collection|Secteurs[]
     */
    public function getSecteurs(): Collection
    {
        return $this->secteurs;
    }

    public function addSecteur(Secteurs $secteur): self
    {
        if (!$this->secteurs->contains($secteur)) {
            $this->secteurs[] = $secteur;
            $secteur->setEtablissements($this);
        }

        return $this;
    }

    public function removeSecteur(Secteurs $secteur): self
    {
        if ($this->secteurs->removeElement($secteur)) {
            // set the owning side to null (unless already changed)
            if ($secteur->getEtablissements() === $this) {
                $secteur->setEtablissements(null);
            }
        }

        return $this;
    }
}
