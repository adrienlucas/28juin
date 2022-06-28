<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Demande;
use App\Entity\StructureDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class DynamiqueDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var StructureDemande $structureDemande */
        $structureDemande = $options['structure_demande'];

        $slugger = new AsciiSlugger();
        foreach($structureDemande->getChamps() as $champ) {
            $champ->addFieldToFormBuilder($builder);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->define('structure_demande');
        $resolver->setRequired('structure_demande');
        $resolver->addAllowedTypes('structure_demande', StructureDemande::class);
    }
}