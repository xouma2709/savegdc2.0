<?php

namespace App\Controller;
use App\Entity\Fonctions;
use App\Form\AddFonctionType;
use App\Form\EditFonctionType;
use App\Repository\FonctionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FonctionsController extends AbstractController
{
    /**
     * @Route("/fonctions", name="fonctions")
     */
    public function index(): Response
    {
        return $this->render('fonctions/index.html.twig', [
            'controller_name' => 'FonctionsController',
        ]);
    }

    /**
     * @Route("/params/fonctions", name="showFonctions")
     */
    public function showFonctions(FonctionsRepository $repo): Response
    {
        $fonctions = $repo->findBy([],['FonctionLibelle' => 'ASC']);
        return $this->render('params/fonctions/index.html.twig', ['Fonctions' => $fonctions]);
    }

    /**
     * @Route("/params/fonctions/addFonction", name="addFonction")
     */
    public function addFonction(Request $request, EntityManagerInterface $em, FonctionsRepository $repo): Response
    {

        $fonction= new Fonctions();
        $form = $this->createForm(AddFonctionType::class, $fonction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {


        $em ->persist($fonction);
        $em->flush();

        $fonctions = $repo->findBy([],['FonctionLibelle' => 'ASC']);
        return $this->redirectToRoute('showFonctions', ['Fonctions' => $fonctions]);

        }

        return $this->render('params/fonctions/addFonction.html.twig', [
            'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/params/fonctions/{id}", name="fonction")
     */
    public function Fonction($id, FonctionsRepository $repo): Response
    {
        $fonctions = $repo->find($id);
        return $this->render('params/fonctions/detail.html.twig', ['Fonctions' => $fonctions]);
    }

    /**
     * @Route("/params/fonctions/edit/{id}", name="editFonction")
     */
    public function editFonction($id, FonctionsRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        $fonction = $repo->find($id);
        $form = $this->createForm(EditFonctionType::class, $fonction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {


        $em ->persist($fonction);
        $em->flush();

        return new Response("Le logiciel a été modifié");

        }

        return $this->render('params/fonctions/editFonction.html.twig', [
            'form' => $form->createView()
            ]);

    }
}
