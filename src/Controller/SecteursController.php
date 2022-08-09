<?php


namespace App\Controller;
use App\Entity\Secteurs;
use App\Entity\Etablissements;
use App\Form\AddSecteurType;
use App\Form\EditSecteurType;
use App\Repository\SecteursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecteursController extends AbstractController
{
    /**
     * @Route("/secteurs", name="secteurs")
     */
    public function index(): Response
    {
        return $this->render('secteurs/index.html.twig', [
            'controller_name' => 'SecteursController',
        ]);
    }

    
    /**
     * @Route("/params/secteurs", name="showSecteurs")
     */
    public function showSecteurs(SecteursRepository $repo): Response
    {       
        $secteurs = $repo->findAll();
        return $this->render('params/secteurs/index.html.twig', ['Secteurs' => $secteurs]);
    }

    /**
     * @Route("/params/secteurs/addSecteur", name="addSecteur")
     */
    public function addSecteur(Request $request, EntityManagerInterface $em): Response
    {
     
        $secteur= new Secteurs();
        $form = $this->createForm(AddSecteurType::class, $secteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        

        $em ->persist($secteur);
        $em->flush();

        return new Response('Le secteur a été ajouté à la liste');
        
    }
        
        return $this->render('params/secteurs/addSecteur.html.twig', [
            'form' => $form->createView()
            ]);
        
    }

    /**
     * @Route("/params/secteurs/{id}", name="secteur")
     */
    public function Secteur($id, SecteursRepository $repo): Response
    {       
        $secteurs = $repo->find($id);
        return $this->render('params/secteurs/detail.html.twig', ['Secteurs' => $secteurs]);
    }

    /**
     * @Route("/params/secteurs/edit/{id}", name="editSecteur")
     */
    public function editSecteur($id, SecteursRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        $secteur = $repo->find($id);
        $form = $this->createForm(EditSecteurType::class, $secteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        

        $em ->persist($secteur);
        $em->flush();

        return new Response("Le secteur a été modifié");
        
        }
        
        return $this->render('params/secteurs/editSecteur.html.twig', [
            'form' => $form->createView()
            ]);
        
    }
}
