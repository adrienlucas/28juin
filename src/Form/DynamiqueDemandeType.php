<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Demande;
use App\Entity\StructureDemande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DynamiqueDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', EntityType::class, [
            'class' => StructureDemande::class,
            'choice_label' => 'type',
            'placeholder' => 'Choisir le type de demande'
        ]);

        //
//        $dynamiqueFormModifier = function(FormEvent $event) {
        $dynamiqueFormModifier = function(FormInterface $form, ?Demande $demande) {

//            $form = $event->getForm();
//            dump($event->getData());
//            dump($event->getForm()->get('type')->getData());

//            /** @var StructureDemande $structure */
//            $structure = $form->get('type')->getNormData();

            if($demande === null || $demande->getType() === null) {
                return;
            }

            $structureDemande = $demande->getType();

            foreach($structureDemande->getChamps() as $champ) {
                $formType = $champ->getSymfonyFormType();
                $form->add(
                    $champ->getNom(),
                    $formType,
                    ['mapped' => false]
                );
            }
        };

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            dump($event->getData());
            dump($event->getForm()->getViewData());
        });

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event)use ($dynamiqueFormModifier) {
            $dynamiqueFormModifier($event->getForm(), $event->getData());
        });

//        $builder->addEventListener(
//            FormEvents::PRE_SET_DATA,
//            function (FormEvent $event) use ($dynamiqueFormModifier) {
//                // this would be your entity, i.e. SportMeetup
//                $data = $event->getData();
//
//                $dynamiqueFormModifier($event->getForm(), $data);
//            }
//        );
//
//        $builder->get('type')->addEventListener(
//            FormEvents::POST_SUBMIT,
//            function (FormEvent $event) use ($dynamiqueFormModifier) {
//                // It's important here to fetch $event->getForm()->getData(), as
//                // $event->getData() will get you the client data (that is, the ID)
//                $structure = $event->getForm()->getData();
//
//                // since we've added the listener to the child, we'll have to pass on
//                // the parent to the callback functions!
//                $dynamiqueFormModifier($event->getForm()->getParent(), $structure);
//            }
//        );


//
//        $builder->addModelTransformer(new class implements DataTransformerInterface{
//
//            public function transform($value)
//            {
//                // TODO: Implement transform() method.
//            }
//
//            public function reverseTransform($value)
//            {
//                // TODO: Implement reverseTransform() method.
//            }
//        });
//
//        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
//            dump($event->getData());
//            dump($event->getForm()->getViewData());
//        });
//        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
//            dump($event->getData());
//            dump($event->getForm()->getViewData());
//        });
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
//            dump($event->getData());
////            dump($event->getForm()->getViewData());
//        });
//        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
//            dump($event->getData());
//            dump($event->getForm()->getViewData());
//        });
//        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
//            dump($event->getData());
//            dump($event->getForm()->getViewData());
//        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('allow_extra_fields', true);
        $resolver->setDefault('data_class', Demande::class);
    }
}