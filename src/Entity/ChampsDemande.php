<?php

namespace App\Entity;

use App\Repository\ChampsDemandeTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @ORM\Entity()
 */
class ChampsDemande
{
    public const TYPE_INPUT = 'input';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_SELECT= 'select';
    public const TYPE_DATE = 'date';

    public const TYPES = [
        self::TYPE_INPUT,
        self::TYPE_TEXTAREA,
        self::TYPE_CHECKBOX,
        self::TYPE_SELECT,
        self::TYPE_DATE,
    ];

    public function getSymfonyFormType(): string
    {
        switch($this->type) {
            case self::TYPE_INPUT:
                return TextType::class;
            case self::TYPE_TEXTAREA:
                return TextareaType::class;
            case self::TYPE_CHECKBOX:
                return CheckboxType::class;
            case self::TYPE_SELECT:
                return ChoiceType::class;
            case self::TYPE_DATE:
                return DateType::class;
            default:
                throw new \LogicException(sprintf('The "%s" type is not supported', $this->type));
        }
    }

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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $options = [];

    /**
     * @ORM\ManyToOne(targetEntity=StructureDemande::class, inversedBy="champs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $structure;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getStructure(): ?StructureDemande
    {
        return $this->structure;
    }

    public function setStructure(?StructureDemande $structure): self
    {
        $this->structure = $structure;

        return $this;
    }
}
