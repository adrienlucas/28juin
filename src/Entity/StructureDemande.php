<?php

namespace App\Entity;

use App\Repository\StructureDemandeTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class StructureDemande
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=ChampsDemande::class, mappedBy="structure", orphanRemoval=true, cascade={"persist"})
     */
    private $champs;

    /**
     * @ORM\OneToMany(targetEntity=Demande::class, mappedBy="type")
     */
    private $demandes;

    public function __construct()
    {
        $this->champs = new ArrayCollection();
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, ChampsDemande>
     */
    public function getChamps(): Collection
    {
        return $this->champs;
    }

    public function addChamp(ChampsDemande $champ): self
    {
        if (!$this->champs->contains($champ)) {
            $this->champs[] = $champ;
            $champ->setStructure($this);
        }

        return $this;
    }

    public function removeChamp(ChampsDemande $champ): self
    {
        if ($this->champs->removeElement($champ)) {
            // set the owning side to null (unless already changed)
            if ($champ->getStructure() === $this) {
                $champ->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setType($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getType() === $this) {
                $demande->setType(null);
            }
        }

        return $this;
    }
}
