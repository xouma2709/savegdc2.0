<?php

namespace App\Controller;

use App\Entity\Comptes;
use App\Form\AddCompteType;
use App\Form\EditCompteType;
use App\Repository\AgentsRepository;
use App\Repository\ComptesRepository;
use App\Repository\ContratsRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\EtablissementsRepository;
use App\Repository\FonctionsRepository;
use App\Repository\SecteursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Snappy\Pdf; 
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;




class ComptesController extends AbstractController
{
    /**
     * @Route("/comptes", name="comptes")
     */
    public function index(ComptesRepository $repo): Response
    {

        $comptes = $repo->findAll();
        return $this->render('comptes/index.html.twig', ['Comptes' => $comptes]);


    }
    
    /**
     * @Route("/comptes/addCompte", name="addCompte")
     */
    public function addCompte(Request $request, EntityManagerInterface $em): Response
    {
     
        $compte= new Comptes();
        $form = $this->createForm(AddCompteType::class, $compte);

        $pwd = passgen2(12);
        $today = date(Y-m-j);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        
        $compte->setPwd($pwd);
        $compte ->setDateCreation($today);
        $compte ->setDateModif($today);

        $em ->persist($compte);
        $em->flush();

        return $this->render('/comptes/addCompteOK.html.twig', [
            'form' => $form->createView()
            ]);
        }
        
        return $this->render('/comptes/addCompte.html.twig', [
            'form' => $form->createView()
            ]);
        
    }

    /**
     * @Route("/comptes/{id}", name="compte")
     */
    public function Compte($id, ComptesRepository $repo): Response
    {       
        $comptes = $repo->find($id);
        return $this->render('comptes/detail.html.twig', ['Comptes' => $comptes]);
    }

    /**
     * @Route("/comptes/{id}/enveloppe", name="enveloppe")
     */
    public function generateEnveloppe($id, ComptesRepository $repo, Pdf $knpSnappyPdf, ContratsRepository $repocontrat): Response
    {
        $comptes = $repo->find($id);
        $agent = $comptes->getAgents();
        $compte = $repo->findBy(['agents' => $agent]);
        $contrats = $repocontrat->findBy(['agents' => $agent]);
        $idagent = $agent->getId();
        $lastcontrat = $repocontrat->findOneBy([],['id'=>'desc']);
        $lastidcontrat = $lastcontrat->getId();
        $options = [
            'page-size' => 'B5',
            'orientation' => 'Landscape',
            'margin-top' => 25,
            'margin-bottom' => 25,
            'margin-left' => 25,
            'margin-right' => 25,
        ];
        $knpSnappyPdf->setOptions($options);
        

         new PdfResponse(
            $knpSnappyPdf->generateFromHtml(
                $this->renderView(
                    '/comptes/enveloppe.html.twig',
                    ['Comptes' => $comptes, 'Contrat' => $lastcontrat]
                    ),
                './tmp/enveloppes/enveloppe'.$id.'.pdf'
                ));

                return $this->redirectToRoute('agent', ['id' => $idagent] );

            
            }

    /**
     * @Route("/comptes/{id}/courrier", name="courrier")
     */
    public function generateCourrier($id, ComptesRepository $repo, Pdf $knpSnappyPdf, ContratsRepository $repocontrat): Response
    {
        $comptes = $repo->find($id);
        $agent = $comptes->getAgents();
        $compte = $repo->findBy(['agents' => $agent]);
        $idagent = $agent->getId();

        $contrats = $repocontrat->findBy(['agents' => $agent]);
        $lastcontrat = $repocontrat->findOneBy([],['id'=>'desc']);
        $lastidcontrat = $lastcontrat->getId();
        //$html = $this -> renderView('/comptes/courrier.html.twig', ['Comptes' => $comptes]);
        $options = [
            'margin-top' => 10,
            'margin-bottom' => 10,
            'margin-left' => 10,
            'margin-right' => 10,
        ];
        $knpSnappyPdf->setOptions($options);
         new PdfResponse(
            $knpSnappyPdf->generateFromHtml(
                $this->renderView(
                    '/comptes/courrier.html.twig',
                    ['Comptes' => $comptes, 'Contrat' => $lastcontrat, 'Compte' => $compte]
                    ),
                './tmp/publi/courrier'.$id.'.pdf'
                ));
    
                return $this->redirectToRoute('agent', ['id' => $idagent] );

        
                

    }
    /**
     * @Route("/comptes/edit/{id}", name="editCompte")
     */
    public function editCompte($id, ComptesRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        $compte = $repo->find($id);
        $form = $this->createForm(EditCompteType::class, $compte);
        $today = date(Y-m-j);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {          
        
            $compte ->setDateModif($today);

        $em ->persist($compte);
        $em->flush();

        return new Response("Le compte a été modifié");
        
        }
        
        return $this->render('comptes/editCompte.html.twig', [
            'form' => $form->createView()
            ]);
        
    }

    
}
