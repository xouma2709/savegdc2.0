<?php

namespace App\Entity;

use App\Repository\AgentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentsRepository::class)
 */
class Agents
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PrenomAutres;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Secteurs::class, inversedBy="agents")
     */
    private $Secteur;

    /**
     * @ORM\ManyToOne(targetEntity=Fonctions::class, inversedBy="agents")
     */
    private $Fonction;

    /**
     * @ORM\OneToMany(targetEntity=Comptes::class, mappedBy="agents")
     */
    private $Comptes;

    /**
     * @ORM\OneToMany(targetEntity=Contrats::class, mappedBy="agents")

     */
    private $Contrats;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $Softs = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $EnvoiMail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $EnvoiSms;

    public function __construct()
    {
        $this->Comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getPrenomAutres(): ?string
    {
        return $this->PrenomAutres;
    }

    public function setPrenomAutres(?string $PrenomAutres): self
    {
        $this->PrenomAutres = $PrenomAutres;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(?string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->Tel;
    }

    public function setTel(?string $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(?string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getSecteur(): ?Secteurs
    {
        return $this->Secteur;
    }

    public function setSecteur(?Secteurs $Secteur): self
    {
        $this->Secteur = $Secteur;

        return $this;
    }

    public function getFonction(): ?Fonctions
    {
        return $this->Fonction;
    }

    public function setFonction(?Fonctions $Fonction): self
    {
        $this->Fonction = $Fonction;

        return $this;
    }

    /**
     * @return Collection|Comptes[]
     */
    public function getComptes(): Collection
    {
        return $this->Comptes;
    }

    public function addCompte(Comptes $compte): self
    {
        if (!$this->Comptes->contains($compte)) {
            $this->Comptes[] = $compte;
            $compte->setAgents($this);
        }

        return $this;
    }

    public function removeCompte(Comptes $compte): self
    {
        if ($this->Comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getAgents() === $this) {
                $compte->setAgents(null);
            }
        }

        return $this;
    }




    /**
     * @return Collection|Contrats[]
     */
    public function getContrats(): Collection
    {
        return $this->Contrats;
    }

    public function addContrat(Contrats $contrat): self
    {
        if (!$this->Contrats->contains($contrat)) {
            $this->Contrats[] = $contrat;
            $contrat->setAgents($this);
        }

        return $this;
    }

    public function removeContrat(Contrats $contrat): self
    {
        if ($this->Contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getAgents() === $this) {
                $contrat->setAgents(null);
            }
        }

        return $this;
    }








    public function getSofts(): ?array
    {
        return $this->Softs;
    }

    public function setSofts(?array $Softs): self
    {
        $this->Softs = $Softs;

        return $this;
    }

    public function getEnvoiMail(): ?bool
    {
        return $this->EnvoiMail;
    }

    public function setEnvoiMail(?bool $EnvoiMail): self
    {
        $this->EnvoiMail = $EnvoiMail;

        return $this;
    }

    public function getEnvoiSms(): ?bool
    {
        return $this->EnvoiSms;
    }

    public function setEnvoiSms(?bool $EnvoiSms): self
    {
        $this->EnvoiSms = $EnvoiSms;

        return $this;
    }
}
