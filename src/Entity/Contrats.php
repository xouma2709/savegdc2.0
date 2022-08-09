
<?php

namespace App\Entity;

use App\Repository\ContratsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContratsRepository::class)
 */
class Contrats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateFin;



    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Actif;

    /**
     * @ORM\ManyToOne(targetEntity=Agents::class, inversedBy="Contrats")
     */
    private $agents;

    /**
     * @ORM\ManyToOne(targetEntity=TypesContrat::class, inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TypeContrat;

    /**
     * @ORM\Column(type="integer")
     */
    private $preuve;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $createur;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateAjout;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $dernierContrat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(?\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }



    public function getActif(): ?bool
    {
        return $this->Actif;
    }

    public function setActif(?bool $Actif): self
    {
        $this->Actif = $Actif;

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

    public function getTypeContrat(): ?TypesContrat
    {
        return $this->TypeContrat;
    }

    public function setTypeContrat(?TypesContrat $TypeContrat): self
    {
        $this->TypeContrat = $TypeContrat;

        return $this;
    }

    public function getPreuve(): ?int
    {
        return $this->preuve;
    }

    public function setPreuve(int $preuve): self
    {
        $this->preuve = $preuve;

        return $this;
    }

    public function getCreateur(): ?string
    {
        return $this->createur;
    }

    public function setCreateur(?string $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->DateAjout;
    }

    public function setDateAjout(?\DateTimeInterface $DateAjout): self
    {
        $this->DateAjout = $DateAjout;

        return $this;
    }

    public function getDernierContrat(): ?bool
    {
        return $this->dernierContrat;
    }

    public function setDernierContrat(?bool $dernierContrat): self
    {
        $this->dernierContrat = $dernierContrat;

        return $this;
    }


}
