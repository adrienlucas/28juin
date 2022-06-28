<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\StructureDemande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TypeDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', EntityType::class, [
            'class' => StructureDemande::class,
            'choice_label' => 'type',
            'placeholder' => 'Choisir le type de demande'
        ]);
    }
}