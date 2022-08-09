<?php

namespace App\Controller;

use App\Entity\TypesContrat;
use App\Form\AddTypeContratType;
use App\Form\EditTypeContratType;
use App\Repository\TypesContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypescontratController extends AbstractController
{
    /**
     * @Route("/typescontrat", name="typescontrat")
     */
    public function index(): Response
    {
        return $this->render('typescontrat/index.html.twig', [
            'controller_name' => 'TypescontratController',
        ]);
    }

    /**
     * @Route("/params/typescontrat", name="showtypescontrat")
     */
    public function showTypesContrat(TypesContratRepository $repo): Response
    {       
        $typescontrat = $repo->findAll();
        return $this->render('params/typescontrat/index.html.twig', ['TypesContrat' => $typescontrat]);
    }

    /**
     * @Route("/params/typescontrat/addTypeContrat", name="addtypecontrat")
     */
    public function addTypeContrat(Request $request, EntityManagerInterface $em): Response
    {
     
        $typecontrat= new TypesContrat();
        $form = $this->createForm(AddTypeContratType::class, $typecontrat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        

        $em ->persist($typecontrat);
        $em->flush();

        return new Response('Le logiciel a été ajouté à la liste');
        
    }
        
        return $this->render('params/typescontrat/addtypecontrat.html.twig', [
            'form' => $form->createView()
            ]);
        
    }

    /**
     * @Route("/params/typescontrat/{id}", name="typecontrat")
     */
    public function TypeContrat($id, TypesContratRepository $repo): Response
    {       
        $typescontrat = $repo->find($id);
        return $this->render('params/typescontrat/detail.html.twig', ['TypesContrat' => $typescontrat]);
    }

    /**
     * @Route("/params/typescontrat/edit/{id}", name="editTypeContrat")
     */
    public function editTypeContrat($id, TypesContratRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        $typecontrat = $repo->find($id);
        $form = $this->createForm(EditTypeContratType::class, $typecontrat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        

        $em ->persist($typecontrat);
        $em->flush();

        return new Response("Le logiciel a été modifié");
        
        }
        
        return $this->render('params/typescontrat/edittypecontrat.html.twig', [
            'form' => $form->createView()
            ]);
        
    }
}
