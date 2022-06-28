<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=StructureDemande::class, inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @deprecated
     * @ORM\Column(type="json", nullable=true)
     */
    private $details;

    /**
     * @ORM\OneToMany(targetEntity=DemandeDetail::class, mappedBy="demande", orphanRemoval=true, cascade={"persist"})
     */
    private $demandeDetails;

    public function __construct()
    {
        $this->demandeDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?StructureDemande
    {
        return $this->type;
    }

    public function setType(?StructureDemande $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function setDetails($details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Collection<int, DemandeDetail>
     */
    public function getDemandeDetails(): Collection
    {
        return $this->demandeDetails;
    }

    public function addDemandeDetail(DemandeDetail $demandeDetail): self
    {
        if (!$this->demandeDetails->contains($demandeDetail)) {
            $this->demandeDetails[] = $demandeDetail;
            $demandeDetail->setDemande($this);
        }

        return $this;
    }

    public function removeDemandeDetail(DemandeDetail $demandeDetail): self
    {
        if ($this->demandeDetails->removeElement($demandeDetail)) {
            // set the owning side to null (unless already changed)
            if ($demandeDetail->getDemande() === $this) {
                $demandeDetail->setDemande(null);
            }
        }

        return $this;
    }
}
