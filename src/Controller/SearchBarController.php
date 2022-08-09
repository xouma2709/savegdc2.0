<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Agents;
use App\Form\SearchBarType;
use App\Form\SearchMenuType;
use App\Repository\AgentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SearchBarController extends AbstractController
{
  /**
  * @Route("/search/bar", name="app_search_bar")
  */
  public function index(Request $request, EntityManagerInterface $em, AgentsRepository $agentsRepository): Response
  {
    $form = $this->createForm(SearchBarType::class);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid())
    {
      $next=$form->get('exacte')->isClicked();
      if($next == true){
        $criteria = $form->getData();
        //dd($criteria);
        $agents = $agentsRepository->searchAgents($criteria);
      return $this->render('/agents/index.html.twig', ['Agents' => $agents]);
      }
      $next=$form->get('partielle')->isClicked();
      if($next == true){
        $criteria = $form->getData();
        //dd($criteria);
        $agents = $agentsRepository->searchAgentsAPeuPres($criteria);
      return $this->render('/agents/index.html.twig', ['Agents' => $agents]);
    }else{
      $criteria = $form->getData();
      //dd($criteria);
      $agents = $agentsRepository->searchAgentsAPeuPres($criteria);
    return $this->render('/agents/index.html.twig', ['Agents' => $agents]);

    }

    }
    return $this->render('/search_bar/index.html.twig', [
      'form' => $form->createView()
    ]);

  }
  /**
  * @Route("/search/searchmenu", name="searchMenu")
  */
    public function searchMenu(Request $request, AgentsRepository $agentsRepository): Response
    {
      $form = $this->createForm(SearchMenuType::class);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid())
      {
          $criteria = $form->getData();
          //dd($criteria);

          $agents = $agentsRepository->generalSearch($criteria);
        return $this->render('/agents/index.html.twig', ['Agents' => $agents]);
      }


      return $this->render('/search_bar/searchBar.html.twig', [
        'form' => $form->createView()
      ]);

    }
}
