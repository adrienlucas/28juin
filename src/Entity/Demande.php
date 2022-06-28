<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
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
     * @ORM\Column(type="text")
     */
    private $details;

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

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails($details): self
    {
        $this->details = $details;

        return $this;
    }
}
