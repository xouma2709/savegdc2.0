<?php

namespace App\Controller;
use App\Entity\Softs;
use App\Form\AddSoftType;
use App\Form\EditSoftType;
use App\Repository\SoftsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoftsController extends AbstractController
{
    /**
     * @Route("/softs", name="softs")
     */
    public function index(): Response
    {
        return $this->render('softs/index.html.twig', [
            'controller_name' => 'SoftsController',
        ]);
    }

    /**
     * @Route("/params/softs", name="showSofts")
     */
    public function showSofts(SoftsRepository $repo): Response
    {
        $softs = $repo->findBy([],['SoftLibelle' => 'ASC']);
        return $this->render('params/softs/index.html.twig', ['Softs' => $softs]);
    }

    /**
     * @Route("/params/softs/addSoft", name="addSoft")
     */
    public function addSoft(Request $request, EntityManagerInterface $em, SoftsRepository $repo): Response
    {

        $soft= new Softs();
        $form = $this->createForm(AddSoftType::class, $soft);
        $softs = $repo->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

        $soft->setActif(1);
        $em ->persist($soft);
        $em->flush();

        return $this->redirectToRoute('showSofts', ['Softs' => $softs] );

    }

        return $this->render('params/softs/addSoft.html.twig', [
            'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/params/softs/{id}", name="soft")
     */
    public function Soft($id, SoftsRepository $repo): Response
    {
        $softs = $repo->find($id);
        return $this->render('params/softs/detail.html.twig', ['Softs' => $softs]);
    }

    /**
     * @Route("/params/softs/edit/{id}", name="editSoft")
     */
    public function editSoft($id, SoftsRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        $soft = $repo->find($id);
        $form = $this->createForm(EditSoftType::class, $soft);
        $softs = $repo->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {


        $em ->persist($soft);
        $em->flush();

        return $this->redirectToRoute('showSofts', ['Softs' => $softs] );

        }

        return $this->render('params/softs/editSoft.html.twig', [
            'form' => $form->createView()
            ]);

    }
}
