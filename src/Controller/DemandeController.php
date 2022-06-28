<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\StructureDemande;
use App\Form\DynamiqueDemandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    /**
     * @Route("/demande/{id}", name="app_demande", defaults={"id": null})
     */
    public function index(?StructureDemande $structureDemande = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $demande = new Demande();

        $builder->add('type', EntityType::class, [
            'class' => StructureDemande::class,
            'choice_label' => 'type',
            'placeholder' => 'Choisir le type de demande'
        ]);


        $form = $this->createForm(DynamiqueDemandeType::class, $demande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Demande $demande */
            $demande = $form->getData();
            $entityManager->persist($demande);
            $entityManager->flush();
        }

        return $this->render('demande/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
