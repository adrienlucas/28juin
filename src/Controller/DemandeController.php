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
     * @Route("/demande", name="app_demande")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DynamiqueDemandeType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            dump($form->getExtraData());
            /** @var Demande $demande */
            $demande = $form->getData();
            $demande->setDetails($form->getExtraData());

            $entityManager->persist($demande);
            $entityManager->flush();
        }

        return $this->render('demande/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
