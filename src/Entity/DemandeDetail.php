<?php

namespace App\Entity;

use App\Repository\DemandeDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeDetailRepository::class)
 */
class DemandeDetail
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
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $valeur;

    /**
     * @ORM\ManyToOne(targetEntity=Demande::class, inversedBy="demandeDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $demande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getValeur()
    {
        $unserializedValue = unserialize($this->valeur);
        return $unserializedValue;
    }

    public function isDate()
    {
        return $this->getValeur() instanceof \DateTime;
    }

    public function setValeur($valeur): self
    {
        $serializedValue = serialize($valeur);
        $this->valeur = $serializedValue;
//        $this->valeur = $valeur;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }
}
