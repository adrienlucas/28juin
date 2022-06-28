<?php

namespace App\Entity;

use App\Repository\ChampsDemandeTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $options;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $default;

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default): void
    {
        $this->default = $default;
    }

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

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(?string $options): self
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

    public function addFieldToFormBuilder(FormBuilderInterface $builder): void
    {
        switch($this->type) {
            case self::TYPE_INPUT:
                $formType = TextType::class;
                $formOptions = [];
                break;
            case self::TYPE_TEXTAREA:
                $formType = TextareaType::class;
                $formOptions = [];
                break;
            case self::TYPE_CHECKBOX:
                $formType = CheckboxType::class;
                $formOptions = [];
                break;
            case self::TYPE_SELECT:
                $formType = ChoiceType::class;
                $choices = explode(',', $this->options);
                $formOptions = ['choices' => array_combine($choices, $choices)];
                break;
            case self::TYPE_DATE:
                $formType = DateType::class;
                $formOptions = ['widget' => 'single_text'];
                break;
            default:
                throw new \LogicException(sprintf('The "%s" type is not supported', $this->type));
        }

        $slugger = new AsciiSlugger();
        $builder->add(
            $slugger->slug($this->getNom())->toString(),
            $formType,
            array_merge(['label' => $this->getNom()], $formOptions)
        );
    }

    public static function getSymfonyFormType($type): string
    {
        switch($type) {
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
                throw new \LogicException(sprintf('The "%s" type is not supported', $type));
        }
    }
}
