<?php

namespace App\Form;

use App\Entity\ChampsDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChampsDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type', ChoiceType::class, [
                'choices' => array_combine(ChampsDemande::TYPES, ChampsDemande::TYPES),
            ])
            ->add('options', TextareaType::class, [
                'required' => false
            ])
        ;

        $defaultAdder = function($form, $data){
            $defaultType = $data !== null ? ChampsDemande::getSymfonyFormType($data) : TextType::class;
            $form->add('default', $defaultType);
        };

        $builder->get('type')->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($defaultAdder) {
            $defaultAdder($event->getForm()->getParent(), $event->getData());
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChampsDemande::class,
        ]);
    }
}
