<?php

namespace App\Entity;

use App\Repository\ComptesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComptesRepository::class)
 */
class Comptes
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
    private $login;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pwd;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="date")
     */
    private $DateModif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Createur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Modificateur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $admin;


    /**
     * @ORM\ManyToOne(targetEntity=Agents::class, inversedBy="Comptes")
     */
    private $agents;

    /**
     * @ORM\ManyToMany(targetEntity=Softs::class, inversedBy="comptes")
     */
    private $softs;

    public function __construct()
    {
        $this->softs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPwd(): ?string
    {
        return $this->pwd;
    }

    public function setPwd(string $pwd): self
    {
        $this->pwd = $pwd;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->DateModif;
    }

    public function setDateModif(\DateTimeInterface $DateModif): self
    {
        $this->DateModif = $DateModif;

        return $this;
    }

    public function getCreateur(): ?string
    {
        return $this->Createur;
    }

    public function setCreateur(?string $Createur): self
    {
        $this->Createur = $Createur;

        return $this;
    }

    public function getModificateur(): ?string
    {
        return $this->Modificateur;
    }

    public function setModificateur(?string $Modificateur): self
    {
        $this->Modificateur = $Modificateur;

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

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }


    public function getAgents(): ?Agents
    {
        return $this->agents;
    }

    public function setAgents(?Agents $agents): self
    {
        $this->agents = $agents;

        return $this;
    }

    /**
     * @return Collection|Softs[]
     */
    public function getSofts(): Collection
    {
        return $this->softs;
    }

    public function addSoft(Softs $soft): self
    {
        if (!$this->softs->contains($soft)) {
            $this->softs[] = $soft;
        }

        return $this;
    }

    public function removeSoft(Softs $soft): self
    {
        $this->softs->removeElement($soft);

        return $this;
    }
}
