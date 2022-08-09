<?php

namespace App\Controller;
use App\Entity\Etablissements;
use App\Form\AddEtabType;
use App\Form\EditEtabType;
use App\Repository\EtablissementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtabController extends AbstractController
{
    /**
     * @Route("/etab", name="etabl")
     */
    public function index(): Response
    {
        return $this->render('etab/index.html.twig', [
            'controller_name' => 'EtabController',
        ]);
    }

    /**
     * @Route("/params/etab", name="showEtab")
     */
    public function showEtab(EtablissementsRepository $repo): Response
    {       
        $etab = $repo->findAll();
        return $this->render('params/etab/index.html.twig', ['Etablissements' => $etab]);
    }

    /**
     * @Route("/params/etab/addEtab", name="addEtab")
     */
    public function addEtab(Request $request, EntityManagerInterface $em): Response
    {
     
        $etab= new Etablissements();
        $form = $this->createForm(AddEtabType::class, $etab);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        

        $em ->persist($etab);
        $em->flush();

        return new Response('L\'Etablissement a été ajouté à la liste');
        
    }
        
        return $this->render('params/etab/addEtab.html.twig', [
            'form' => $form->createView()
            ]);
        
    }

    /**
     * @Route("/params/etab/{id}", name="Etab")
     */
    public function Etab($id, EtablissementsRepository $repo): Response
    {       
        $etabs = $repo->find($id);
        return $this->render('params/etab/detail.html.twig', ['Etablissements' => $etabs]);
    }

    /**
     * @Route("/params/etab/edit/{id}", name="editEtab")
     */
    public function editEtab($id, EtablissementsRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        $Etab = $repo->find($id);
        $form = $this->createForm(EditEtabType::class, $Etab);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        

        $em ->persist($Etab);
        $em->flush();

        return new Response("L\'etablissements a été modifié");
        
        }
        
        return $this->render('params/etab/editEtab.html.twig', [
            'form' => $form->createView()
            ]);
        
    }
}


