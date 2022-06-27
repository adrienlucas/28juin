<?php

namespace App\Controller;

use App\Form\StructureDemandeType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StructureDemandeType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $structure = $form->getData();
//            dump($structure);
            $entityManager->persist($structure);
            $entityManager->flush();
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
